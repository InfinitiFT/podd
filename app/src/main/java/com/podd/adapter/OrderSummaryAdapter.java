package com.podd.adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import com.podd.R;
import com.podd.model.SavedItem;

import java.util.ArrayList;
import java.util.List;


public class OrderSummaryAdapter extends  RecyclerView.Adapter<OrderSummaryAdapter.MyViewHolder>{
    private final Context context;
    private List<SavedItem> restaurantList = new ArrayList<>();
    SavedItem savedItem;


    /**
     * Instantiates a new Best restaurant adapter.
     *
     * @param context        the context
     * @param restaurantList the restaurant list
     */
    public OrderSummaryAdapter(Context context, List<SavedItem> restaurantList) {

        this.context = context;
        this.restaurantList = restaurantList;


    }


    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_order_summary, parent, false);
        return new OrderSummaryAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final MyViewHolder holder, final int position) {
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.tvNoOfQuantity.setTypeface(typefaceRegular);
        holder.tvItemName.setTypeface(typefaceRegular);
        holder.tvCost.setTypeface(typefaceRegular);

        savedItem = restaurantList.get(position);

        holder.tvNoOfQuantity.setText(savedItem.count+"x");
        holder.tvItemName.setText(""+savedItem.item_name);
        String price = savedItem.price;
        String[] split = price.split("£");

        String split_one = split[0];
        String split_second = split[1];
        double actualPrice = Double.valueOf(split_second)*savedItem.count;
        holder.tvCost.setText("£"+String.format("%.2f",actualPrice));
    }


    @Override
    public int getItemCount() {
        return restaurantList.size();
    }

    /**
     * The type My view holder.
     */
    public class MyViewHolder extends RecyclerView.ViewHolder {

        private TextView tvNoOfQuantity;
        private TextView tvItemName;
        private TextView tvCost;


        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            tvNoOfQuantity = (TextView) itemView.findViewById(R.id.tvNoOfQuantity);
            tvItemName = (TextView) itemView.findViewById(R.id.tvItemName);
            tvCost = (TextView) itemView.findViewById(R.id.tvCost);
        }
    }
}
