package com.podd.adapter;

import android.app.Activity;
import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.podd.R;
import com.podd.model.Restaurant;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Raj Kumar on 3/8/2017
 * for Mobiloitte
 */

public class SelectFitnessCategoryAdapter extends RecyclerView.Adapter<SelectFitnessCategoryAdapter.MyViewHolder> {
    private final Context context;
    private List<Restaurant> restaurantList = new ArrayList<>();



    public SelectFitnessCategoryAdapter(Context context) {

        this.context = context;
        this.restaurantList = restaurantList;


    }


    @Override
    public SelectFitnessCategoryAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_fintness_grid, parent, false);
        return new SelectFitnessCategoryAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final SelectFitnessCategoryAdapter.MyViewHolder holder, final int position) {
        Typeface typeface = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Bold.ttf");
        holder.tvVanuName.setTypeface(typeface);
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.tvLocation.setTypeface(typefaceRegular);
        holder.tvDistance.setTypeface(typefaceRegular);
        holder.tvCategory.setTypeface(typefaceRegular);
        holder.tvAvailability.setTypeface(typefaceRegular);


        holder.llFotter.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText((Activity)context,"Work in progress.",Toast.LENGTH_SHORT).show();

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
        private LinearLayout llFotter;
        private TextView tvVanuName;
        private TextView tvCategory;
        private TextView tvDistance;
        private TextView tvAvailability;
        private TextView tvLocation;


        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            llFotter = (LinearLayout) itemView.findViewById(R.id.llFotter);

            tvVanuName = (TextView) itemView.findViewById(R.id.tvVanuName);
            tvCategory = (TextView) itemView.findViewById(R.id.tvCategory);
            tvDistance = (TextView) itemView.findViewById(R.id.tvDistance);
            tvAvailability = (TextView) itemView.findViewById(R.id.tvAvailability);
            tvLocation = (TextView) itemView.findViewById(R.id.tvLocation);
           ;

        }
    }
}
