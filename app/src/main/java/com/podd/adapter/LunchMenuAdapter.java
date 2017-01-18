package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.podd.R;

public class LunchMenuAdapter extends RecyclerView.Adapter <LunchMenuAdapter.MyViewHolder>{
    private final Context context;
    public LunchMenuAdapter(Context context) {
        this.context=context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.row_items_menu_adapter, parent, false);
        return new LunchMenuAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        SubItemMenuAdapter subItemMenuAdapter = new SubItemMenuAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context);
        holder.rvSubItemMenu.setLayoutManager(mLayoutManager);
        holder.rvSubItemMenu.setAdapter(subItemMenuAdapter);


    }



    @Override
    public int getItemCount() {
        return 3 ;
    }


    public class MyViewHolder extends RecyclerView.ViewHolder {

        private TextView tvItem;
        private RecyclerView rvSubItemMenu;

               public MyViewHolder(View itemView) {
            super(itemView);
            tvItem= (TextView) itemView.findViewById(R.id.tvItem);
            rvSubItemMenu= (RecyclerView) itemView.findViewById(R.id.rvSubItemMenu);
        }
    }
}
