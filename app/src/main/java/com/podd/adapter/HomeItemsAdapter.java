package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.activityRestaurant.BestRestaurantNearCity;
import com.podd.activityRestaurant.BestRestaurantNearCityForDelivery;
import com.podd.model.HomeItemsModel;
import com.squareup.picasso.Picasso;

import java.util.List;


public class HomeItemsAdapter extends RecyclerView.Adapter<HomeItemsAdapter.MyViewHolder> {
    private final Context context;
    private List<HomeItemsModel>homeItemsModelList;
    private Intent intent;

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
        if(homeItemsModel.service_image!= null){
            Picasso.with(context).load(homeItemsModel.service_image).into(holder.ivItemImage);
        }

        if(homeItemsModel.service_name!= null){
            holder.tvItemName.setText(homeItemsModel.service_name);
        }
        final String serviceName = homeItemsModel.service_name;

        holder.ivItemImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                switch(serviceName){
                    case "Front Desk":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Restaurants & Bars":
                        intent=new Intent(context, BestRestaurantNearCity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        context.startActivity(intent);
                        break;
                    case "Delivery":
                        intent=new Intent(context, BestRestaurantNearCityForDelivery.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        context.startActivity(intent);
                        break;
                    case "Taxi & Limousines":
                        Toast.makeText(context, R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Car Hire":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Health & Wellness":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Beauty services":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Art & Culture":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Happening in London":
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                }
            }
        });



        /*if (position==1){
            holder.ivItemImage.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    intent=new Intent(context, BestRestaurantNearCity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    context.startActivity(intent);
                }
            });
        }*/


    }


    @Override
    public int getItemCount() {
        return homeItemsModelList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        private final TextView tvItemName;
        private final ImageView ivItemImage;
        public MyViewHolder(View itemView) {
            super(itemView);
            tvItemName= (TextView) itemView.findViewById(R.id.tvItemName);
            ivItemImage= (ImageView) itemView.findViewById(R.id.ivItemImage);
        }
    }
}
