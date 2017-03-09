package com.podd.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.activityFitnessWellbeing.FitnessBookNowActivity;
import com.podd.model.AttractionModel;

import java.util.List;

/**
 * Created by Raj Kumar on 3/8/2017
 * for Mobiloitte
 */

public class SelectFitnessCategoryAdapter extends RecyclerView.Adapter<SelectFitnessCategoryAdapter.MyViewHolder> {
private final Context context;
    private List<AttractionModel> attractionModels;



public SelectFitnessCategoryAdapter(Context context,List<AttractionModel>attractionModels) {

    this.context = context;
    this.attractionModels = attractionModels;


}

@Override
public SelectFitnessCategoryAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_fintness_grid, parent, false);
        return new SelectFitnessCategoryAdapter.MyViewHolder(view);
        }

@Override
public void onBindViewHolder(final SelectFitnessCategoryAdapter.MyViewHolder holder, final int position) {
    final AttractionModel attractionModel = attractionModels.get(position);
        Typeface typeface = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Bold.ttf");
        holder.tvVanuName.setTypeface(typeface);
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.tvLocation.setTypeface(typefaceRegular);
        holder.tvDistance.setTypeface(typefaceRegular);
        holder.tvCategory.setTypeface(typefaceRegular);
        holder.tvAvailability.setTypeface(typefaceRegular);
    holder.tvLocation.setText(attractionModel.getAttraction_location());
    holder.tvVanuName.setText(attractionModel.getAttraction_name());
    holder.tvCategory.setText(attractionModel.getAttraction_category());
    Glide.with(context).load(attractionModel.getAttraction_image()).error(R.mipmap.podd).placeholder(R.mipmap.podd).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivRestaurant);


        holder.flMain.setOnClickListener(new View.OnClickListener() {
@Override
public void onClick(View view) {
        Intent intent=new Intent(context, FitnessBookNowActivity.class).setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        context.startActivity(intent);

        }
        });
        }


@Override
public int getItemCount() {
        return attractionModels.size();
        }

/**
 * The type My view holder.
 */
public class MyViewHolder extends RecyclerView.ViewHolder {
    private LinearLayout llFotter;
    private TextView tvVanuName;
    private TextView tvCategory;
    private TextView tvDistance;
    private TextView tvAvailability;
    private TextView tvLocation;
    private ImageView ivRestaurant;
    FrameLayout flMain;


    /**
     * Instantiates a new My view holder.
     *
     * @param itemView the item view
     */
    public MyViewHolder(View itemView) {
        super(itemView);
        llFotter = (LinearLayout) itemView.findViewById(R.id.llFotter);
        flMain = (FrameLayout) itemView.findViewById(R.id.flMain);

        tvVanuName = (TextView) itemView.findViewById(R.id.tvVanuName);
        tvCategory = (TextView) itemView.findViewById(R.id.tvCategory);
        tvDistance = (TextView) itemView.findViewById(R.id.tvDistance);
        tvAvailability = (TextView) itemView.findViewById(R.id.tvAvailability);
        tvLocation = (TextView) itemView.findViewById(R.id.tvLocation);
        ivRestaurant = (ImageView) itemView.findViewById(R.id.ivRestaurant);


    }
}
}
