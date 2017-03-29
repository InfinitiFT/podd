package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.model.AirportListModel;
import com.podd.model.RestaturantNameList;

import java.util.List;

/**
 * Created by vinay.tripathi on 23/3/17.
 */

public class RestaturantNameAdapter extends RecyclerView.Adapter<RestaturantNameAdapter.MyViewHolder> {
    private final Context context;
    private List<RestaturantNameList> restaturantNameLists;

    public RestaturantNameAdapter(Context context, List<RestaturantNameList>restaturantNameLists) {
        this.context=context;
        this.restaturantNameLists=restaturantNameLists;
    }
    @Override
    public RestaturantNameAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_restaurant_name, parent, false);
        return new RestaturantNameAdapter.MyViewHolder(view);
    }
    @Override
    public void onBindViewHolder(final RestaturantNameAdapter.MyViewHolder holder, final int position) {
        final RestaturantNameList restaturantNameList = restaturantNameLists.get(position);

        if(restaturantNameList.image_url!=null&&restaturantNameList.image_url.length()>0){

            Glide.with(context).load(restaturantNameList.image_url).error(Color.parseColor("#000000")).placeholder(Color.parseColor("#000000")).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivImage);
        }
        if(restaturantNameList.restaurant_name!=null&&restaturantNameList.restaurant_name.length()>0){
            holder.tvRestaurantName.setText(restaturantNameList.restaurant_name);
        }

    }
    @Override
    public int getItemCount() {
        return restaturantNameLists.size();
    }
    public class MyViewHolder extends RecyclerView.ViewHolder {
        private final ImageView ivImage;
        private final TextView tvRestaurantName;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivImage= (ImageView) itemView.findViewById(R.id.ivImage);
            tvRestaurantName= (TextView) itemView.findViewById(R.id.tvRestaurantName);
        }
    }
}