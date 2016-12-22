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

import com.podd.R;
import com.podd.activityrestauarant.RestaurantDetailScreenActivity;
import com.podd.model.Ambience;
import com.podd.model.Cuisine;
import com.podd.model.Dietary;
import com.podd.model.PriceRange;
import com.podd.model.Restaurant;
import com.squareup.picasso.Picasso;

import java.util.List;

/**
 * Created by Shalini Bishnoi on 13-12-2016.
 */
public class BestRestaurantAdapter extends RecyclerView.Adapter<BestRestaurantAdapter.MyViewHolder> {
    private Context context;
    private List<Restaurant>restaurantList;

    /**
     * Instantiates a new Best restaurant adapter.
     *
     * @param context        the context
     * @param restaurantList the restaurant list
     */
    public BestRestaurantAdapter(Context context, List<Restaurant> restaurantList) {

        this.context=context;
        this.restaurantList=restaurantList;


    }



    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_grid_layout, parent, false);
        return new BestRestaurantAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {

        if (position%2==0){
            holder.viewBottom.setVisibility(View.VISIBLE);
        }
        else {
            holder.viewBottom.setVisibility(View.GONE);
        }
        Restaurant restaurant = restaurantList.get(position);
       /* Cuisine cuisine=restaurantList.get(position).cuisine.get(position);
        PriceRange prceRange=restaurantList.get(position).price_range.get(position);
        Ambience ambience=restaurantList.get(position).ambience.get(position);
        Dietary dietary=restaurantList.get(position).dietary.get(position);*/
        holder.tvRestaurantName.setText(restaurantList.get(position).restaurant_name);
        holder.tvLocation.setText(restaurantList.get(position).location);
        holder.tvDistance.setText(restaurantList.get(position).distance);
        /*holder.tvPriceRange.setText(restaurantList.get(position).price_range.get(position).price_range);
        holder.tvtypeofRestaurant.setText(restaurantList.get(position).cuisine.get(position).cuisine_name);*/
        if(restaurantList.get(position).restaurant_images!=null){
            Picasso.with(context)
                    .load(restaurantList.get(position).restaurant_images)
                    .placeholder(R.mipmap.podd) // optional
                    .error(R.mipmap.podd)         // optional
                    .into(holder.ivRestaurant);
        }else {
            holder.ivRestaurant.setImageResource(R.mipmap.podd);
        }


        holder.llMain.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent=new Intent(context, RestaurantDetailScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
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
            llMain= (LinearLayout) itemView.findViewById(R.id.llMain);
            ivRestaurant= (ImageView) itemView.findViewById(R.id.ivRestaurant);
            tvRestaurantName= (TextView) itemView.findViewById(R.id.tvRestaurantName);
            tvtypeofRestaurant= (TextView) itemView.findViewById(R.id.tvtypeofRestaurant);
            tvLocation= (TextView) itemView.findViewById(R.id.tvLocation);
            tvDistance= (TextView) itemView.findViewById(R.id.tvDistance);
            tvPriceRange= (TextView) itemView.findViewById(R.id.tvPriceRange);
            viewBottom=itemView.findViewById(R.id.viewBottom);

        }
    }
}
