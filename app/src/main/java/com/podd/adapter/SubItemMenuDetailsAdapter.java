package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.podd.R;

/**
 * Created by Shalini Bishnoi on 17-01-2017.
 */
public class SubItemMenuDetailsAdapter extends RecyclerView.Adapter<SubItemMenuDetailsAdapter.MyViewHolder> {
    private Context context;
    public SubItemMenuDetailsAdapter(Context context) {
        this.context=context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.row_items_sub_items_details, parent, false);
        return new SubItemMenuDetailsAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {


    }



    @Override
    public int getItemCount() {
        return 2;
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        public MyViewHolder(View itemView) {
            super(itemView);
        }
    }
}
