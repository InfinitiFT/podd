package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.podd.R;

/**
 * Created by Shalini Bishnoi on 12-12-2016.
 */
public class RestaurantsAdapter extends RecyclerView.Adapter<RestaurantsAdapter.MyViewHolder> {
    private Context context;

    /**
     * Instantiates a new Restaurants adapter.
     *
     * @param context the context
     */
    public RestaurantsAdapter(Context context) {
        context=this.context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_restaurants, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {


    }


    @Override
    public int getItemCount() {
        return 10;
    }

    /**
     * The type My view holder.
     */
    public class MyViewHolder extends RecyclerView.ViewHolder {
        /**
         * The Iv restaurant image.
         */
        ImageView ivRestaurantImage;
        /**
         * The Ll star restaurants.
         */
        LinearLayout llStarRestaurants;

        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            ivRestaurantImage= (ImageView) itemView.findViewById(R.id.ivRestaurantImage);
            llStarRestaurants= (LinearLayout) itemView.findViewById(R.id.llStarRestaurants);
        }
    }
}
