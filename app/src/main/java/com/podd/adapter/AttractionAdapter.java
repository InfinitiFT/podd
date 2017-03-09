package com.podd.adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.podd.R;
import com.podd.model.AttractionModel;

import java.util.List;

/**
 * Created by Raj Kumar on 3/9/2017
 * for Mobiloitte
 */

public class AttractionAdapter extends RecyclerView.Adapter<AttractionAdapter.MyViewHolder> {
    private final Context context;
    private List<AttractionModel> attractionModels;



    public AttractionAdapter(Context context,List<AttractionModel>attractionModels) {

        this.context = context;
        this.attractionModels = attractionModels;


    }


    @Override
    public AttractionAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_attraction_grid, parent, false);
        return new AttractionAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final AttractionAdapter.MyViewHolder holder, final int position) {
        final AttractionModel attractionModel = attractionModels.get(position);
        Typeface typefaceRegular = Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
        holder.tvAttractionName.setTypeface(typefaceRegular);
        holder.tvAttractionCategory.setTypeface(typefaceRegular);
        holder.tvAttractionLocation.setTypeface(typefaceRegular);
        holder.tvAttractionLocation.setText(attractionModel.getAttraction_location());
        holder.tvAttractionName.setText(attractionModel.getAttraction_name());
        holder.tvAttractionCategory.setText(attractionModel.getAttraction_category());
        Glide.with(context).load(attractionModel.getAttraction_image()).error(R.mipmap.podd).placeholder(R.mipmap.podd).diskCacheStrategy(DiskCacheStrategy.ALL).into(holder.ivAttraction);


        holder.flMain.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
              /*  Intent intent=new Intent(context, FitnessBookNowActivity.class).setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                context.startActivity(intent);*/
                Toast.makeText(context,"Work in progress",Toast.LENGTH_SHORT).show();

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

        private ImageView ivAttraction;
        private TextView tvAttractionName;
        private TextView tvAttractionCategory;
        private TextView tvAttractionLocation;
        private FrameLayout flMain;


        /**
         * Instantiates a new My view holder.
         *
         * @param itemView the item view
         */
        public MyViewHolder(View itemView) {
            super(itemView);
            flMain = (FrameLayout) itemView.findViewById(R.id.flMain);
            ivAttraction = (ImageView) itemView.findViewById(R.id.ivAttraction);
            tvAttractionName = (TextView) itemView.findViewById(R.id.tvAttractionName);
            tvAttractionCategory = (TextView) itemView.findViewById(R.id.tvAttractionCategory);
            tvAttractionLocation = (TextView) itemView.findViewById(R.id.tvAttractionLocation);



        }
    }
}
