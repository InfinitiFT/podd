package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.activityrestauarant.RestaurantDetailScreenActivity;
import com.podd.model.Restaurant;
import com.podd.utils.AppConstant;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Shalini Bishnoi on 13-12-2016.
 */
public class BestRestaurantAdapter extends RecyclerView.Adapter<BestRestaurantAdapter.MyViewHolder> {
    private Context context;
    private List<Restaurant> restaurantList = new ArrayList<>();
    private String location;


    /**
     * Instantiates a new Best restaurant adapter.
     *
     * @param context        the context
     * @param restaurantList the restaurant list
     */
    public BestRestaurantAdapter(Context context, List<Restaurant> restaurantList) {

        this.context = context;
        this.restaurantList = restaurantList;


    }


    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_grid_layout, parent, false);
        return new BestRestaurantAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, final int position) {

        if (position % 2 == 0) {
            holder.viewBottom.setVisibility(View.VISIBLE);
        } else {
            holder.viewBottom.setVisibility(View.GONE);
        }
        Restaurant restaurant = restaurantList.get(position);
        holder.tvRestaurantName.setText(restaurant.restaurant_name);
        holder.tvLocation.setText(restaurant.location);
        location = holder.tvLocation.getText().toString().trim();
        holder.tvDistance.setText(restaurant.distance);
        holder.tvPriceRange.setText(restaurant.price_range);

        if (restaurantList.get(position).cuisine != null && restaurantList.get(position).cuisine.size() > 0) {


            holder.tvtypeofRestaurant.setText(restaurantList.get(position).cuisine.get(0).cuisine_name);
        } else if (restaurantList.get(position).dietary != null && restaurantList.get(position).dietary.size() > 0) {
            holder.tvtypeofRestaurant.setText(restaurantList.get(position).dietary.get(0).dietary_name);
        } else if (restaurantList.get(position).ambience != null && restaurantList.get(position).ambience.size() > 0) {
            holder.tvtypeofRestaurant.setText(restaurantList.get(position).ambience.get(0).ambience_name);
        } else {
            holder.tvtypeofRestaurant.setText(R.string.cuisine);
        }


        if (restaurantList.get(position).restaurant_images.get(0) != null) {
            Picasso.with(context)
                    .load(restaurantList.get(position).restaurant_images.get(0).toString())
                    .placeholder(R.color.colorPrimaryDark) // optional
                    .error(R.color.colorPrimaryDark)         // optional
                    .into(holder.ivRestaurant);
        } else {
            holder.ivRestaurant.setImageResource(R.color.colorPrimaryDark);
        }


        holder.llMain.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, RestaurantDetailScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra(AppConstant.RESTAURANTID, restaurantList.get(position).restaurant_id);
                intent.putExtra(AppConstant.LATITUDE, restaurantList.get(position).latitude);
                intent.putExtra(AppConstant.LONGITUDE, restaurantList.get(position).longitude);
                intent.putExtra(location, location);
                context.startActivity(intent);
            }
        });
    }


    @Override
    public int getItemCount() {
        return restaurantList.size();
    }

    /**
     * The type My view holder.
     */
    public class MyViewHolder extends RecyclerView.ViewHolder {
        private LinearLayout llMain;
        private ImageView ivRestaurant;
        private TextView tvRestaurantName;
        private TextView tvtypeofRestaurant;
        private TextView tvLocation;
        private TextView tvDistance;
        private TextView tvPriceRange;
        private View viewBottom;

        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            llMain = (LinearLayout) itemView.findViewById(R.id.llMain);
            ivRestaurant = (ImageView) itemView.findViewById(R.id.ivRestaurant);
            tvRestaurantName = (TextView) itemView.findViewById(R.id.tvRestaurantName);
            tvtypeofRestaurant = (TextView) itemView.findViewById(R.id.tvtypeofRestaurant);
            tvLocation = (TextView) itemView.findViewById(R.id.tvLocation);
            tvDistance = (TextView) itemView.findViewById(R.id.tvDistance);
            tvPriceRange = (TextView) itemView.findViewById(R.id.tvPriceRange);
            viewBottom = itemView.findViewById(R.id.viewBottom);

        }
    }
}
