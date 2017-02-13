package com.podd.adapter;

import android.app.Dialog;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.podd.R;
import com.squareup.picasso.Picasso;

import java.util.List;


public class RestaurantsAdapter extends RecyclerView.Adapter<RestaurantsAdapter.MyViewHolder> {
    private final Context context;
    private final List<String>restaurantList;


    public RestaurantsAdapter(Context context, List<String> restaurantList) {
        this.context=context;
        this.restaurantList=restaurantList;

    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_items_restaurants, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, final int position) {
        if(restaurantList.get(position)!=null){
            for (int i = 0; i <restaurantList.size() ; i++) {
                Picasso.with(context)
                        .load(restaurantList.get(position)).error(R.mipmap.placeholder_icon).placeholder(R.mipmap.placeholder_icon)
                        .into(holder.ivRestaurantImage);
            }
        }else {
            holder.ivRestaurantImage.setImageResource(R.mipmap.placeholder_icon);
        }

        holder.ivRestaurantImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showCustomPopupWindow(context, restaurantList.get(position));
            }
        });


    }
    @Override
    public int getItemCount() {
        return restaurantList.size();
    }
    public class MyViewHolder extends RecyclerView.ViewHolder {
        final ImageView ivRestaurantImage;
        final LinearLayout llStarRestaurants;
        public MyViewHolder(View itemView) {
            super(itemView);
            ivRestaurantImage= (ImageView) itemView.findViewById(R.id.ivRestaurantImage);
            llStarRestaurants= (LinearLayout) itemView.findViewById(R.id.llStarRestaurants);
        }
    }

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
