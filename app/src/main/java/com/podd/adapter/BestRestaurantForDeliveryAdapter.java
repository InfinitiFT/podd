package com.podd.adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.podd.R;
import com.podd.activityRestaurant.ViewMenuActivity;
import com.podd.model.Restaurant;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;


@SuppressWarnings("ALL")
public class BestRestaurantForDeliveryAdapter extends RecyclerView.Adapter<BestRestaurantForDeliveryAdapter.MyViewHolder> {
    private final Context context;
    private List<Restaurant> restaurantList = new ArrayList<>();
    private String location;


    /**
     * Instantiates a new Best restaurant adapter.
     *
     * @param context        the context
     * @param restaurantList the restaurant list
     */
    public BestRestaurantForDeliveryAdapter(Context context, List<Restaurant> restaurantList) {

        this.context = context;
        this.restaurantList = restaurantList;


    }


    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_grid_layout, parent, false);
        return new BestRestaurantForDeliveryAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final MyViewHolder holder, int position) {

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

        if (restaurant.price_range != null) {
            String priceRange = restaurant.price_range;
            String[] split = priceRange.split("-");

            String split_one = split[0];
            String split_second = split[1];
            holder.tvPriceRange.setText("$ " + split_one + " - " + "$ " + split_second);
        } else {
            holder.tvPriceRange.setText("$" + restaurantList.get(position).price_range);
        }

        if (restaurantList.get(position).cuisine != null && restaurantList.get(position).cuisine.size() > 0) {
            holder.tvtypeOfRestaurant.setText(restaurantList.get(position).cuisine.get(0).cuisine_name);
        } else if (restaurantList.get(position).dietary != null && restaurantList.get(position).dietary.size() > 0) {
            holder.tvtypeOfRestaurant.setText(restaurantList.get(position).dietary.get(0).dietary_name);
        } else if (restaurantList.get(position).ambience != null && restaurantList.get(position).ambience.size() > 0) {
            holder.tvtypeOfRestaurant.setText(restaurantList.get(position).ambience.get(0).ambience_name);
        } else {
            holder.tvtypeOfRestaurant.setText(R.string.cuisine);
        }

        holder.ivRestaurant.getLayoutParams().height = (CommonUtils.getDeviceWidth((Activity) context) / 2);
        if (restaurantList.get(position).restaurant_images.get(0) != null && restaurantList.get(position).restaurant_images.size() > 0) {
            Picasso.with(context)
                    .load(restaurantList.get(position).restaurant_images.get(0))
                    .placeholder(R.mipmap.placeholder_icon) // optional
                    .error(R.mipmap.placeholder_icon)         // optional
                    .into(holder.ivRestaurant);
        } else {
            holder.ivRestaurant.setImageResource(R.color.colorPrimaryDark);
        }


        holder.llMain.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, ViewMenuActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra(AppConstant.RESTAURANTID, restaurantList.get(holder.getAdapterPosition()).restaurant_id);
                intent.putExtra(AppConstant.LATITUDE, restaurantList.get(holder.getAdapterPosition()).latitude);
                intent.putExtra(AppConstant.LONGITUDE, restaurantList.get(holder.getAdapterPosition()).longitude);
                intent.putExtra(AppConstant.LOCATION, location);
                intent.putExtra(AppConstant.RESTAURANTNAME, restaurantList.get(holder.getAdapterPosition()).restaurant_name);
                intent.putExtra(AppConstant.RESTAURANTIMAGES, restaurantList.get(holder.getAdapterPosition()).restaurant_images);
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
        private TextView tvtypeOfRestaurant;
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
            tvtypeOfRestaurant = (TextView) itemView.findViewById(R.id.tvtypeofRestaurant);
            tvLocation = (TextView) itemView.findViewById(R.id.tvLocation);
            tvDistance = (TextView) itemView.findViewById(R.id.tvDistance);
            tvPriceRange = (TextView) itemView.findViewById(R.id.tvPriceRange);
            viewBottom = itemView.findViewById(R.id.viewBottom);

        }
    }
}
