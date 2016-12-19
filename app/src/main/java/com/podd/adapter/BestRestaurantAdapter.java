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

/**
 * Created by Shalini Bishnoi on 13-12-2016.
 */
public class BestRestaurantAdapter extends RecyclerView.Adapter<BestRestaurantAdapter.MyViewHolder> {
    private Context context;

    /**
     * Instantiates a new Best restaurant adapter.
     *
     * @param context the context
     */
    public BestRestaurantAdapter(Context context) {
        this.context=context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_grid_layout, parent, false);
        return new BestRestaurantAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
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
        return 10;
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

        }
    }
}
