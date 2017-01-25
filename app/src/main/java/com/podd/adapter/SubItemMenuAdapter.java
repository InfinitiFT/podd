package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.podd.R;


public class SubItemMenuAdapter extends RecyclerView.Adapter <SubItemMenuAdapter.MyViewHolder>{
    private final Context context;
    public SubItemMenuAdapter(Context context) {
        this.context=context;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {

    View view = LayoutInflater.from(context).inflate(R.layout.row_sub_items_menu, parent, false);
    return new SubItemMenuAdapter.MyViewHolder(view);
}
    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {


    }



    @Override
    public int getItemCount() {
        return 3;
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {

        public MyViewHolder(View itemView) {
            super(itemView);

        }
    }
}
