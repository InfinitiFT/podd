package com.podd.adapter;

import android.content.Context;
import android.graphics.Color;
import android.support.v4.view.PagerAdapter;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.model.HomeImageModel;


import java.util.List;

public class HomePagerAdapter extends PagerAdapter {
    private final Context context;

    private final List<HomeImageModel> imgList;

    public HomePagerAdapter(Context context, List<HomeImageModel> imgList) {
        this.context = context;
        this.imgList = imgList;
    }

    @Override
    public Object instantiateItem(ViewGroup collection, int position) {
        //  ModelObject modelObject = ModelObject.values()[position];
        LayoutInflater inflater = LayoutInflater.from(context);
        ViewGroup layout = (ViewGroup) inflater.inflate(R.layout.row_home_pager, collection, false);
        ImageView ivPager = (ImageView) layout.findViewById(R.id.ivPager);
        TextView tvImageDetail = (TextView) layout.findViewById(R.id.tvImageDetail);
        if (imgList.get(position).image_url != null && imgList.get(position).image_url.length() > 0) {

            Glide.with(context).load(imgList.get(position).image_url).error(Color.parseColor("#000000")).placeholder(Color.parseColor("#000000")).diskCacheStrategy(DiskCacheStrategy.ALL).into(ivPager);
        }
        if (imgList.get(position).image_message != null && imgList.get(position).image_message.length() > 0) {
            tvImageDetail.setText(imgList.get(position).image_message);
        }
        //  ivPager.setImageResource(imgList.get(position));
        collection.addView(layout);
        return layout;
    }

    @Override
    public void destroyItem(ViewGroup collection, int position, Object view) {
        collection.removeView((View) view);
    }

    @Override
    public int getCount() {
        return imgList.size();
    }

    @Override
    public boolean isViewFromObject(View view, Object object) {
        return view == object;
    }

    @Override
    public CharSequence getPageTitle(int position) {
        // ModelObject customPagerEnum = ModelObject.values()[position];
        return "";
    }

    /*@Override
    public View getView(final int position, View view, ViewGroup container) {
        ViewHolder holder;
        if (view != null) {
            holder = (ViewHolder) view.getTag();
        } else {
            view = LayoutInflater.from(container.getContext()).inflate(R.layout.row_home_pager, container, false);
            holder = new ViewHolder(view);
            holder.ivPager.setImageResource(img[position]);
            *//*if(img.get(position) != null && arlThisWeek.get(position).length() > 0) {
                Picasso.with(context).load(arlThisWeek.get(position)).resize(200, 200).memoryPolicy(MemoryPolicy.NO_CACHE)
                        .networkPolicy(NetworkPolicy.NO_CACHE).into(holder.ivPager);
            }*//*
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
    }*/


}