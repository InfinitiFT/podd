package com.podd.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.podd.R;
import com.squareup.picasso.MemoryPolicy;
import com.squareup.picasso.NetworkPolicy;
import com.squareup.picasso.Picasso;

import com.zanlabs.widget.infiniteviewpager.InfinitePagerAdapter;

import java.util.List;

public class HomePagerAdapter extends InfinitePagerAdapter {
    private Context context;

    private int[] img;

    public HomePagerAdapter(Context context, int[] img) {
        this.context = context;
        this.img = img;
    }

    @Override
    public View getView(final int position, View view, ViewGroup container) {
        ViewHolder holder;
        if (view != null) {
            holder = (ViewHolder) view.getTag();
        } else {
            view = LayoutInflater.from(container.getContext()).inflate(R.layout.row_home_pager, container, false);
            holder = new ViewHolder(view);
            holder.ivPager.setImageResource(img[position]);
            /*if(img.get(position) != null && arlThisWeek.get(position).length() > 0) {
                Picasso.with(context).load(arlThisWeek.get(position)).resize(200, 200).memoryPolicy(MemoryPolicy.NO_CACHE)
                        .networkPolicy(NetworkPolicy.NO_CACHE).into(holder.ivPager);
            }*/
            view.setTag(holder);
        }
        return view;
    }

    @Override
    public int getItemCount() {
        return img.length;
    }

    private class ViewHolder {
        private final ImageView ivPager;
        public int position;


        public ViewHolder(View view) {
            ivPager = (ImageView) view.findViewById(R.id.ivPager);
        }
    }


}