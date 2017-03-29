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
import com.podd.model.AirportListModel;
import com.podd.model.HomeItemsModel;
import java.util.List;
/**
 * Created by Raj Kumar on 3/8/2017
 * for Mobiloitte
 */
public class AirprotHeaderImageAdapter extends RecyclerView.Adapter<AirprotHeaderImageAdapter.MyViewHolder> {
    private final Context context;
    private List<AirportListModel> airportListModels;
    private Intent intent;
    private boolean isSelected=false;

    public AirprotHeaderImageAdapter(Context context, List<AirportListModel>airportListModels) {
        this.context=context;
        this.airportListModels=airportListModels;
    }
    @Override
    public AirprotHeaderImageAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_airport_header_image, parent, false);
        return new AirprotHeaderImageAdapter.MyViewHolder(view);
    }
    @Override
    public void onBindViewHolder(final AirprotHeaderImageAdapter.MyViewHolder holder, final int position) {
        final AirportListModel airportListModel = airportListModels.get(position);
        Glide.with(context).load(airportListModel.image_url).error(R.mipmap.podd).placeholder(R.mipmap.podd).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivHeaderImage);
    }
    @Override
    public int getItemCount() {
        return airportListModels.size();
    }
    public class MyViewHolder extends RecyclerView.ViewHolder {
        private final ImageView ivHeaderImage;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivHeaderImage= (ImageView) itemView.findViewById(R.id.ivHeaderImage);
        }
    }
}