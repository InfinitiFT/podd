package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.podd.R;
import com.podd.model.HomeItemsModel;

import java.util.List;

/**
 * Created by Shalini Bishnoi on 31-12-2016.
 */
public class HomeItemsAdapter extends RecyclerView.Adapter<HomeItemsAdapter.MyViewHolder> {
    private Context context;
    private List<HomeItemsModel>homeItemsModelList;
    public HomeItemsAdapter(Context context, List<HomeItemsModel> homeItemsModelList) {
        this.context=context;
        this.homeItemsModelList=homeItemsModelList;


    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_home_screen, parent, false);
        return new HomeItemsAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {

        HomeItemsModel homeItemsModel = homeItemsModelList.get(position);
        holder.ivItemImage.setImageResource(homeItemsModel.getItemImage());
        holder.tvItemName.setText(homeItemsModel.getItemName());


    }


    @Override
    public int getItemCount() {
        return homeItemsModelList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        private TextView tvItemName;
        private ImageView ivItemImage;
        public MyViewHolder(View itemView) {
            super(itemView);
            tvItemName= (TextView) itemView.findViewById(R.id.tvItemName);
            ivItemImage= (ImageView) itemView.findViewById(R.id.ivItemImage);
        }
    }
}
