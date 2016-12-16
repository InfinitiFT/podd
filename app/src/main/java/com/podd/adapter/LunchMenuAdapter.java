package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.podd.R;

/**
 * Created by Shalini Bishnoi on 16-12-2016.
 */
public class LunchMenuAdapter extends RecyclerView.Adapter <LunchMenuAdapter.MyViewHolder>{
    private Context context;
    public LunchMenuAdapter(Context context) {
        this.context=context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_menu_adapter, parent, false);
        return new LunchMenuAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {

    }



    @Override
    public int getItemCount() {
        return 20 ;
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView tvItem;
        public MyViewHolder(View itemView) {
            super(itemView);
            tvItem= (TextView) itemView.findViewById(R.id.tvItem);
        }
    }
}
