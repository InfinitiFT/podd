package com.podd.activityAttraction;

import android.content.Context;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.adapter.AttractionAdapter;
import com.podd.model.AttractionModel;
import com.podd.utils.SetTimerClass;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Raj Kumar on 3/9/2017
 * for Mobiloitte
 */

public class AttractionHomeActivity extends AppCompatActivity implements View.OnClickListener{
    private Context mContext=AttractionHomeActivity.this;
    private String TAG=AttractionHomeActivity.class.getSimpleName();
    private RecyclerView rvAttraction;
    private GridLayoutManager gridLayoutManager;
    private AttractionAdapter attractionAdapter;
    private SetTimerClass setTimerClass;
    private List<AttractionModel>attractionModels=new ArrayList<>();
    private TextView tvSearchBy,tvDate,tvSetDate,tvSelectCategory,tvCategory;
    private TextView tvHeader;
    private String[] attraction_name=new String[]{"Science Museum","Victoria and Albert Museum","National Gallery",
            "British Museum","The Hippodrome Theatre","Madame Tussaud","The London Eye","Sea Life Aquarium","Tate Britain","View from the Shard"};
    private String[] attraction_category=new String[]{"Museum","Museum","Art Gallery","Museum","Theatre","Leisure","Leisure","Leisure","Art Gallery","Leisure"};
    private String[] attraction_location=new String[]{"Kensington","Knightsbridge","Trafalgar Square","Bloomsbury",
            "Leicester Square","Marylebone","Waterloo","Waterloo","Westminster","London Bridge"};
    private int[] attraction_image=new int[]{R.drawable.science_museum,R.drawable.victoria_albert,R.drawable.national_gallery,
    R.drawable.british_museum,R.drawable.hippodrome,R.drawable.madame_tussards,R.drawable.london_eye,R.drawable.sea,R.drawable.tate_britain,R.drawable.shard};
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_attraction_home);
        getIds();
        setListeners();
        setRecycle();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();
    }
    private void getIds()
    {

        tvHeader = (TextView) findViewById(R.id.tvHeader);
        rvAttraction = (RecyclerView) findViewById(R.id.rvAttraction);

        for (int i = 0; i < attraction_name.length; i++) {
            AttractionModel attractionModel = new AttractionModel();
            attractionModel.setAttraction_image(attraction_image[i]);
            attractionModel.setAttraction_name(attraction_name[i]);
            attractionModel.setAttraction_category(attraction_category[i]);
            attractionModel.setAttraction_location(attraction_location[i]);
            attractionModels.add(attractionModel);

        }

    }
    private void setListeners()
    {

    }
    private void setFont()
    {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvHeader.setTypeface(typefaceBold);
    }

    private void setRecycle() {
        gridLayoutManager = new GridLayoutManager(mContext, 2, LinearLayoutManager.HORIZONTAL, false);
        rvAttraction.setLayoutManager(gridLayoutManager);
        attractionAdapter = new AttractionAdapter(mContext,attractionModels);
        rvAttraction.setAdapter(attractionAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId())
        {

        }
    }
    @Override
    protected void onResume() {
        super.onResume();
        setTimerClass.setTimer(this, true);
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        setTimerClass.setTimer(this, true);
    }

    @Override
    public void onUserInteraction() {
        super.onUserInteraction();
        setTimerClass.setTimer(this, false);
    }
}
