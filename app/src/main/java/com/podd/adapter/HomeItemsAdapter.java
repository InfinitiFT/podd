package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.activityRestaurant.BestRestaurantNearCity;
import com.podd.activityRestaurant.BestRestaurantNearCityForDelivery;
import com.podd.model.HomeItemsModel;

import java.util.List;


@SuppressWarnings("ALL")
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
    public void onBindViewHolder(final MyViewHolder holder, int position) {

        HomeItemsModel homeItemsModel = homeItemsModelList.get(position);



        if(homeItemsModel.service_name!= null){
            holder.tvItemName.setText(homeItemsModel.service_name);
        }
        final String serviceName = homeItemsModel.service_name;

        holder.tvItemName.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                switch(serviceName){
                    case "Front Desk":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));
                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Restaurants & Bars":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        intent=new Intent(context, BestRestaurantNearCity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        context.startActivity(intent);
                        break;
                    case "Delivery":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        intent=new Intent(context, BestRestaurantNearCityForDelivery.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        context.startActivity(intent);
                        break;
                    case "Taxi & Limousines":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context, R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Car Hire":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Health & Wellness":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Beauty services":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Art & Culture":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                    case "Happening in London":
                        holder.tvItemName.setBackground(context.getResources().getDrawable(R.drawable.button_white_stroke));

                        Toast.makeText(context,R.string.coming_soon,Toast.LENGTH_SHORT).show();
                        break;
                }
            }
        });

    }


    @Override
    public int getItemCount() {
        return homeItemsModelList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        private final TextView tvItemName;
        public MyViewHolder(View itemView) {
            super(itemView);
            tvItemName= (TextView) itemView.findViewById(R.id.tvItemName);
        }
    }
}
