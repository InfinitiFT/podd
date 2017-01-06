package com.podd.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.podd.R;

public class LunchMenuAdapter extends RecyclerView.Adapter <LunchMenuAdapter.MyViewHolder>{
    private final Context context;

    /**
     * Instantiates a new Lunch menu adapter.
     *
     * @param context the context
     */
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

    /**
     * The type My view holder.
     */
    public class MyViewHolder extends RecyclerView.ViewHolder {
        /**
         * The Tv item.
         */
        final TextView tvItem;

        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            tvItem= (TextView) itemView.findViewById(R.id.tvItem);
        }
    }
}
