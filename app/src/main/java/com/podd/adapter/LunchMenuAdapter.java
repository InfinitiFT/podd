package com.podd.adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.afollestad.sectionedrecyclerview.SectionedRecyclerViewAdapter;
import com.podd.R;
import com.podd.model.MealDetails;

import java.util.ArrayList;
import java.util.List;

public class LunchMenuAdapter extends SectionedRecyclerViewAdapter<LunchMenuAdapter.MainVH> {
    private final Context context;
    private List<MealDetails> meal_details=new ArrayList<>();


    public LunchMenuAdapter(Context context, List<MealDetails> meal_details) {
        this.context=context;
        this.meal_details=meal_details;
    }

    @Override
    public int getSectionCount() {
        return meal_details.size();
    }

    @Override
    public int getItemCount(int section) {

        return meal_details.get(section).subtitle_meal_details.size();
    }

    @Override
    public void onBindHeaderViewHolder(LunchMenuAdapter.MainVH holder, int section) {
        Typeface typefaceBold = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Bold.ttf");
        holder.title.setTypeface(typefaceBold);
        holder.title.setText(meal_details.get(section).subtitle_name);

    }

    @Override
    public int getItemViewType(int section, int relativePosition, int absolutePosition) {
        if (section == meal_details.size())
            return 0; // VIEW_TYPE_HEADER is -2, VIEW_TYPE_ITEM is -1. You can return 0 or greater.
        return super.getItemViewType(section, relativePosition, absolutePosition);
    }

    @Override
    public void onBindViewHolder(LunchMenuAdapter.MainVH holder, int section, int relativePosition, int absolutePosition)
    {
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.title.setTypeface(typefaceRegular);
        holder.titlePrice.setTypeface(typefaceRegular);
        if (meal_details.get(section).subtitle_meal_details!=null&&meal_details.get(section).subtitle_meal_details.size()>0&&meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name!=null) {
            holder.title.setText(String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name, section, relativePosition, absolutePosition));
        }
        else {
            holder.title.setText("");
        }
        if (meal_details.get(section).subtitle_meal_details!=null&&meal_details.get(section).subtitle_meal_details.size()>0&&meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price!=null) {
            holder.titlePrice.setText(String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price, section, relativePosition, absolutePosition));
        }
        else {
            holder.titlePrice.setText("");
        }
    }

    @Override
    public LunchMenuAdapter.MainVH onCreateViewHolder(ViewGroup parent, int viewType) {
        int layout;
        switch (viewType) {
            case VIEW_TYPE_HEADER:
                layout = R.layout.list_item_header;
                break;
            case VIEW_TYPE_ITEM:
                layout = R.layout.list_item_main;
                break;
            default:
                layout = R.layout.list_item_main_bold;
                break;
        }

        View v = LayoutInflater.from(parent.getContext())
                .inflate(layout, parent, false);
        return new MainVH(v);
    }

    public class MainVH extends RecyclerView.ViewHolder {
        final TextView title;
        final TextView titlePrice;

        public MainVH(View itemView) {
            super(itemView);
            title = (TextView) itemView.findViewById(R.id.title);
            titlePrice= (TextView) itemView.findViewById(R.id.titlePrice);
        }
    }
}
