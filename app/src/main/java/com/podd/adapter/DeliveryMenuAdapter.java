package com.podd.adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.afollestad.sectionedrecyclerview.SectionedRecyclerViewAdapter;
import com.podd.R;
import com.podd.eventInterface.AddValueEvent;
import com.podd.eventInterface.MinusValueEvent;
import com.podd.model.MealDetails;
import com.podd.model.RestaurantMenu;
import com.podd.model.SavedItem;
import com.podd.utils.SetTimerClass;

import org.greenrobot.eventbus.EventBus;

import java.util.ArrayList;
import java.util.List;

public class DeliveryMenuAdapter extends SectionedRecyclerViewAdapter<DeliveryMenuAdapter.MainVH> {
    private final Context context;
    private List<MealDetails> meal_details=new ArrayList<>();
    private List<RestaurantMenu> restaurantMenus=new ArrayList<>();
//    int count =0;
    private SavedItem savedItem;


    public DeliveryMenuAdapter(Context context, List<MealDetails> meal_details,List<RestaurantMenu> restaurantMenus) {
        this.context=context;
        this.meal_details=meal_details;
        this.restaurantMenus=restaurantMenus;
        SetTimerClass.savedList.clear();
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
    public void onBindHeaderViewHolder(DeliveryMenuAdapter.MainVH holder, int section) {
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.title.setTypeface(typefaceRegular);
        holder.title.setText(meal_details.get(section).subtitle_name);

    }

    @Override
    public int getItemViewType(int section, int relativePosition, int absolutePosition) {
        if (section == meal_details.size())
            return 0; // VIEW_TYPE_HEADER is -2, VIEW_TYPE_ITEM is -1. You can return 0 or greater.
        return super.getItemViewType(section, relativePosition, absolutePosition);
    }

    @Override
    public void onBindViewHolder(final DeliveryMenuAdapter.MainVH holder, final int section, final int relativePosition, final int absolutePosition) {
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.title.setTypeface(typefaceRegular);
        holder.titlePrice.setTypeface(typefaceRegular);

        if (meal_details.get(section).subtitle_meal_details != null && meal_details.get(section).subtitle_meal_details.size() > 0 && meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name != null) {
            holder.title.setText(String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name, section, relativePosition, absolutePosition));
        } else {
            holder.title.setText("");
        }
        if (meal_details.get(section).subtitle_meal_details != null && meal_details.get(section).subtitle_meal_details.size() > 0 && meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price != null) {
            holder.titlePrice.setText(String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price, section, relativePosition, absolutePosition));
        } else {
            holder.titlePrice.setText("");
        }
        if (meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price.equalsIgnoreCase("")) {
            holder.llPriceEvent.setVisibility(View.GONE);
        }

        holder.tvNumber.setText(""+meal_details.get(section).subtitle_meal_details.get(relativePosition).count);

        holder.ivAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                meal_details.get(section).subtitle_meal_details.get(relativePosition).count=  meal_details.get(section).subtitle_meal_details.get(relativePosition).count+1;
                holder.tvNumber.setText(meal_details.get(section).subtitle_meal_details.get(relativePosition).count);
                if (SetTimerClass.savedList!=null && SetTimerClass.savedList.get(section) != null){
                    SetTimerClass.savedList.get(section).count = meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                }
                SetTimerClass.savedList.get(section).price = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                String price = SetTimerClass.savedList.get(section).price;
                price = price.replace("£", "").trim();
                if (Double.parseDouble(price) > 0.0) {
                    EventBus.getDefault().post(new AddValueEvent(Double.valueOf(price)));
                }
                if(meal_details.get(section).subtitle_meal_details.get(relativePosition).count == 1){
                   savedItem = new SavedItem();
                    savedItem.meal_id = restaurantMenus.get(section).meal_id;
                    savedItem.subtitle_id = meal_details.get(section).subtitle_id;
                    savedItem.item_id = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_id;
                    savedItem.count = meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                    savedItem.price = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                    SetTimerClass.savedList.add(savedItem);
                }
            }
        });

        holder.ivMinus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if (meal_details.get(section).subtitle_meal_details.get(relativePosition).count == 0) {

                } else {
                    SetTimerClass.savedList.get(section).price = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                    String price = SetTimerClass.savedList.get(section).price;
                    price = price.replace("£", "").trim();
                    meal_details.get(section).subtitle_meal_details.get(relativePosition).count = meal_details.get(section).subtitle_meal_details.get(relativePosition).count - 1;
                    holder.tvNumber.setText(meal_details.get(section).subtitle_meal_details.get(relativePosition).count);

                    SetTimerClass.savedList.get(section).count = meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                    if (Double.parseDouble(price) > 0.0) {
                        EventBus.getDefault().post(new MinusValueEvent(Double.valueOf(price)));
                    }
                    if(meal_details.get(section).subtitle_meal_details.get(relativePosition).count == 0){
                        SetTimerClass.savedList.remove(section);
                    }
                }
            }
        });

        if (SetTimerClass.savedList.size() <= restaurantMenus.size()){
            savedItem = new SavedItem();
            savedItem.meal_id = restaurantMenus.get(section).meal_id;
            savedItem.subtitle_id = meal_details.get(section).subtitle_id;
            savedItem.item_id = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_id;
            savedItem.count = meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
            savedItem.price = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
            SetTimerClass.savedList.add(savedItem);
        }
    }

    @Override
    public DeliveryMenuAdapter.MainVH onCreateViewHolder(ViewGroup parent, int viewType) {
        int layout;
        switch (viewType) {
            case VIEW_TYPE_HEADER:
                layout = R.layout.list_item_header;
                break;
            case VIEW_TYPE_ITEM:
                layout = R.layout.list_item_delivery;
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
        final TextView titlePrice,tvNumber;
        final ImageView ivMinus,ivAdd;
        LinearLayout llPriceEvent;

        public MainVH(View itemView) {
            super(itemView);
            title = (TextView) itemView.findViewById(R.id.title);
            titlePrice= (TextView) itemView.findViewById(R.id.titlePrice);
            ivMinus=(ImageView)itemView.findViewById(R.id.ivMinusFragment);
            ivAdd=(ImageView)itemView.findViewById(R.id.ivAddFragment);
            tvNumber=(TextView)itemView.findViewById(R.id.tvNumber);
            llPriceEvent=(LinearLayout) itemView.findViewById(R.id.llPriceEvent);
        }
    }
}
