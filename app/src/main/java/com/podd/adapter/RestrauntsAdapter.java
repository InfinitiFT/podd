package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.podd.R;

/**
 * Created by Shalini Bishnoi on 12-12-2016.
 */
public class RestrauntsAdapter extends RecyclerView.Adapter<RestrauntsAdapter.MyViewHolder> {
    private Context context;
    public RestrauntsAdapter(Context context) {
        context=this.context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_restraunts, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {


    }


    @Override
    public int getItemCount() {
        return 10;
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        ImageView ivRestraunt;
        LinearLayout llStarRestaurants;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivRestraunt= (ImageView) itemView.findViewById(R.id.ivRestraunt);
            llStarRestaurants= (LinearLayout) itemView.findViewById(R.id.llStarRestaurants);
        }
    }
}
