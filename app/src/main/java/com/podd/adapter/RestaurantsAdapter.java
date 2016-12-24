package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.podd.R;
import com.podd.model.Restaurant;
import com.squareup.picasso.Picasso;

import java.util.List;

/**
 * Created by Shalini Bishnoi on 12-12-2016.
 */
public class RestaurantsAdapter extends RecyclerView.Adapter<RestaurantsAdapter.MyViewHolder> {
    private Context context;
    private List<String>restaurantList;


    public RestaurantsAdapter(Context context, List<String> restaurantList) {
        this.context=context;
        this.restaurantList=restaurantList;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_restaurants, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        String restaurant = restaurantList.get(position);
        if(restaurantList.get(position)!=null){
            Picasso.with(context)
                    .load(restaurantList.get(position).toString())
                    .placeholder(R.color.colorPrimaryDark) // optional
                    .error(R.color.colorPrimaryDark)         // optional
                    .into(holder.ivRestaurantImage);
        }else {
            holder.ivRestaurantImage.setImageResource(R.color.colorPrimaryDark);
        }


    }
    @Override
    public int getItemCount() {
        return restaurantList.size();
    }
    public class MyViewHolder extends RecyclerView.ViewHolder {
        ImageView ivRestaurantImage;
        LinearLayout llStarRestaurants;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivRestaurantImage= (ImageView) itemView.findViewById(R.id.ivRestaurantImage);
            llStarRestaurants= (LinearLayout) itemView.findViewById(R.id.llStarRestaurants);
        }
    }
}
