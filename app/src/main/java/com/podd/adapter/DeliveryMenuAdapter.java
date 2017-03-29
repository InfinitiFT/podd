package com.podd.adapter;

import android.app.Dialog;
import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.afollestad.sectionedrecyclerview.SectionedRecyclerViewAdapter;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.activityRestaurant.ViewMenuDeliveryActivity;
import com.podd.eventInterface.AddValueEvent;
import com.podd.eventInterface.MinusValueEvent;
import com.podd.model.MealDetails;
import com.podd.model.RestaurantMenu;
import com.podd.model.SavedItem;
import com.podd.utils.SetTimerClass;
import com.squareup.picasso.Picasso;

import org.greenrobot.eventbus.EventBus;

import java.util.ArrayList;
import java.util.List;

public class DeliveryMenuAdapter extends SectionedRecyclerViewAdapter<DeliveryMenuAdapter.MainVH> {
    private final Context context;
    private List<MealDetails> meal_details = new ArrayList<>();
    private List<RestaurantMenu> restaurantMenus = new ArrayList<>();
    private List<RestaurantMenu> selectedList = new ArrayList<>();
    //    int count =0;
    private SavedItem savedItem;


    public DeliveryMenuAdapter(Context context, List<MealDetails> meal_details, List<RestaurantMenu> restaurantMenus) {
        this.context = context;
        this.meal_details = meal_details;
        this.restaurantMenus = restaurantMenus;
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
    public void onBindViewHolder(final DeliveryMenuAdapter.MainVH holder,
                                 final int section, final int relativePosition,
                                 final int absolutePosition) {
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.title.setTypeface(typefaceRegular);
        holder.titlePrice.setTypeface(typefaceRegular);
        if (meal_details.get(section).subtitle_meal_details != null && meal_details.get(section).subtitle_meal_details.size() > 0 && meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name != null) {
           /* Log.e("log_title",String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name,
                    section, relativePosition, absolutePosition));*/
            String title = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name;
            holder.title.setText(String.format(String.valueOf(title), section, relativePosition, absolutePosition));
        } else {
            holder.title.setText("");
        }
        if (meal_details.get(section).subtitle_meal_details != null && meal_details.get(section).subtitle_meal_details.size() > 0 && meal_details.get(section).subtitle_meal_details.get(relativePosition).item_image != null) {
           /* Log.e("log_title",String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name,
                    section, relativePosition, absolutePosition));*/
            String image = meal_details.get(section).subtitle_meal_details.get(relativePosition).item_image;
            Glide.with(context).load(image).error(R.color.black).placeholder(R.color.black).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivItemImage);
        }
        if (meal_details.get(section).subtitle_meal_details != null && meal_details.get(section).subtitle_meal_details.size() > 0 && meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price != null) {
            holder.titlePrice.setText(String.format(meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price, section, relativePosition, absolutePosition));
        } else {
            holder.titlePrice.setText("");
        }
        if (meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price.equalsIgnoreCase("")) {
            holder.llPriceEvent.setVisibility(View.GONE);
        } else {
            holder.llPriceEvent.setVisibility(View.VISIBLE);
        }

        holder.tvNumber.setText("" + meal_details.get(section).subtitle_meal_details.get(relativePosition).count);


        holder.ivItemImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showCustomPopupWindow(context, meal_details.get(section).subtitle_meal_details.get(relativePosition).item_image);
            }
        });

        holder.ivAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if (restaurantMenus != null && restaurantMenus.size() > 0) {
                    if (restaurantMenus.get(0).meal_details != null && restaurantMenus.get(0).meal_details.size() > 0) {
                        if (restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details != null && restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.size() > 0) {
                            int count_add = 0;
                            count_add = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                            count_add = count_add + 1;
                            restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count = count_add;
                            holder.tvNumber.setText("");
                            holder.tvNumber.setText("" + count_add);

                            String price = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                            price = price.replace("£", "").trim();
                            if (Double.parseDouble(price) > 0.0) {
                                EventBus.getDefault().post(new AddValueEvent(Double.valueOf(price)));
                            }
                            SavedItem savedItem = new SavedItem();
                            savedItem.item_id = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_id;
                            savedItem.count = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                            savedItem.price = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                            savedItem.subtitle_id = restaurantMenus.get(0).meal_details.get(section).subtitle_id;
                            savedItem.meal_id = restaurantMenus.get(0).meal_id;
                            savedItem.item_name = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name;
                            ((ViewMenuDeliveryActivity) context).addItem(savedItem);
                        }
                    }
                }

            }
        });

        holder.ivMinus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if (restaurantMenus != null && restaurantMenus.size() > 0) {
                    if (restaurantMenus.get(0).meal_details != null && restaurantMenus.get(0).meal_details.size() > 0) {
                        if (restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details != null && restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.size() > 0) {
                            int count_add = 0;
                            count_add = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                            if (count_add > 0) {
                                count_add = count_add - 1;
                                String price = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                                price = price.replace("£", "").trim();
                                if (Double.parseDouble(price) > 0.0) {
                                    EventBus.getDefault().post(new MinusValueEvent(Double.valueOf(price)));
                                }
                            }
                            restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count = count_add;
                            holder.tvNumber.setText("");
                            holder.tvNumber.setText("" + count_add);

                            SavedItem savedItem = new SavedItem();
                            savedItem.item_id = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_id;
                            savedItem.count = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).count;
                            savedItem.price = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_price;
                            savedItem.subtitle_id = restaurantMenus.get(0).meal_details.get(section).subtitle_id;
                            savedItem.meal_id = restaurantMenus.get(0).meal_id;
                            savedItem.item_name = restaurantMenus.get(0).meal_details.get(section).subtitle_meal_details.get(relativePosition).item_name;

                            ((ViewMenuDeliveryActivity) context).removeItem(savedItem);
                        }
                    }
                }

            }
        });
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
        final TextView titlePrice, tvNumber;
        final ImageView ivMinus, ivAdd, ivItemImage;
        LinearLayout llPriceEvent;

        public MainVH(View itemView) {
            super(itemView);
            title = (TextView) itemView.findViewById(R.id.title);
            ivItemImage = (ImageView) itemView.findViewById(R.id.ivItemImage);
            titlePrice = (TextView) itemView.findViewById(R.id.titlePrice);
            ivMinus = (ImageView) itemView.findViewById(R.id.ivMinusFragment);
            ivAdd = (ImageView) itemView.findViewById(R.id.ivAddFragment);
            tvNumber = (TextView) itemView.findViewById(R.id.tvNumber);
            llPriceEvent = (LinearLayout) itemView.findViewById(R.id.llPriceEvent);
        }
    }

    /*zoom image */

    private void showCustomPopupWindow(final Context mContext, String imageUrl) {

        LayoutInflater inflater = LayoutInflater.from(mContext);
        final Dialog mDialog = new Dialog(mContext,
                android.R.style.Theme_Translucent_NoTitleBar);
        mDialog.setCanceledOnTouchOutside(true);
        mDialog.getWindow().setLayout(ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.MATCH_PARENT);
        mDialog.getWindow().setGravity(Gravity.CENTER);
        WindowManager.LayoutParams lp = mDialog.getWindow().getAttributes();
        lp.dimAmount = 0.75f;
        mDialog.getWindow()
                .addFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);
        mDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        mDialog.getWindow();
        final ViewGroup nullParent = null;
        View dialogLayout = inflater.inflate(R.layout.image_popup, nullParent);
        mDialog.setContentView(dialogLayout);

        ImageView ivCross=(ImageView)mDialog.findViewById(R.id.ivPicsCross);
        ImageView ivPics=(ImageView)mDialog.findViewById(R.id.ivPics);

        try {
            Picasso.with(context).load(imageUrl).error(R.mipmap.placeholder_icon).placeholder(R.mipmap.placeholder_icon).into(ivPics);
        } catch (Exception e) {
            e.printStackTrace();
        }

        ivCross.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mDialog.dismiss();
            }
        });
        mDialog.show();


    }
}
