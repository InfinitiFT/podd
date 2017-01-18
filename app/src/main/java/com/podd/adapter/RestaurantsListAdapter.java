package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import com.podd.R;



public class RestaurantsListAdapter extends RecyclerView.Adapter<RestaurantsListAdapter.MyViewHolder> {

    /**
     * Instantiates a new Restaurants list adapter.
     *
     * @param context the context
     */
    public RestaurantsListAdapter(Context context) {
        Context context1 = context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_restaurants_list, parent, false);
        return new RestaurantsListAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        holder.llStarRestaurants.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

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
            getIds();
        }

        private void getIds() {
            llStarRestaurants= (LinearLayout) itemView.findViewById(R.id.llStarRestaurants);
        }
    }
}
