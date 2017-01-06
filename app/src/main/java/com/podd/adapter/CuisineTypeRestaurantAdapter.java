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
import com.podd.activityRestaurant.RestaurantDetailScreenActivity;
import com.podd.model.Cuisine;

import java.util.List;


public class CuisineTypeRestaurantAdapter extends RecyclerView.Adapter <CuisineTypeRestaurantAdapter.MyViewHolder>{
    private final Context context;
    private List<Cuisine>cuisineList;

    /**
     * Instantiates a new Cuisine type restaurant adapter.
     *
     * @param context     the context
     * @param cuisineList the cuisine list
     */
    public CuisineTypeRestaurantAdapter(Context context, List<Cuisine> cuisineList) {
        this.cuisineList=cuisineList;
        this.context=context;
    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_grid_layout, parent, false);
        return new CuisineTypeRestaurantAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        if (position%2==0){
            holder.viewBottom.setVisibility(View.VISIBLE);
        }
        else {
            holder.viewBottom.setVisibility(View.GONE);
        }

        Cuisine cuisine = cuisineList.get(position);
        holder.tvRestaurantName.setText(cuisine.name);
        holder.tvDistance.setVisibility(View.GONE);
        holder.tvPriceRange.setVisibility(View.GONE);
        holder.tvtypeOfRestaurant.setVisibility(View.GONE);
        holder.tvLocation.setVisibility(View.GONE);
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
        return cuisineList.size();
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
            llMain= (LinearLayout) itemView.findViewById(R.id.llMain);
            ivRestaurant= (ImageView) itemView.findViewById(R.id.ivRestaurant);
            tvRestaurantName= (TextView) itemView.findViewById(R.id.tvRestaurantName);
            tvtypeOfRestaurant= (TextView) itemView.findViewById(R.id.tvtypeofRestaurant);
            tvLocation= (TextView) itemView.findViewById(R.id.tvLocation);
            tvDistance= (TextView) itemView.findViewById(R.id.tvDistance);
            tvPriceRange= (TextView) itemView.findViewById(R.id.tvPriceRange);
            viewBottom=itemView.findViewById(R.id.viewBottom);

        }
    }
}
