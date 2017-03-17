package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.model.HomeItemsModel;

import java.util.List;

/**
 * Created by Raj Kumar on 3/8/2017
 * for Mobiloitte
 */

public class AirprotHeaderImageAdapter extends RecyclerView.Adapter<AirprotHeaderImageAdapter.MyViewHolder> {
    private final Context context;
    private List<HomeItemsModel> homeItemsModelList;
    private Intent intent;
    private boolean isSelected=false;

    public AirprotHeaderImageAdapter(Context context, List<HomeItemsModel>homeItemsModelList) {
        this.context=context;
        this.homeItemsModelList=homeItemsModelList;
    }

    @Override
    public AirprotHeaderImageAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_airport_header_image, parent, false);
        return new AirprotHeaderImageAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final AirprotHeaderImageAdapter.MyViewHolder holder, final int position) {

        final HomeItemsModel homeItemsModel = homeItemsModelList.get(position);

        Glide.with(context).load(homeItemsModel.getImage()).error(R.mipmap.podd).placeholder(R.mipmap.podd).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivHeaderImage);

    }


    @Override
    public int getItemCount() {
        return homeItemsModelList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        private final ImageView ivHeaderImage;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivHeaderImage= (ImageView) itemView.findViewById(R.id.ivHeaderImage);
        }
    }
}