package com.podd.activityFitnessWellbeing;

import android.content.Context;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.SelectFitnessCategoryAdapter;
import com.podd.model.AttractionModel;
import com.podd.utils.SetTimerClass;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Raj Kumar on 3/8/2017
 * for Mobiloitte
 */

public class SelectFitnessCategoryActivity extends AppCompatActivity implements View.OnClickListener {
    private Context mContext=SelectFitnessCategoryActivity.this;
    private String TAG=SelectFitnessCategoryActivity.class.getSimpleName();
    private LinearLayout llCategory,llDate;
    private  RecyclerView rvFitness;
    private GridLayoutManager gridLayoutManager;
    private SelectFitnessCategoryAdapter selectCategoryFitnessAdapter;
    private SetTimerClass setTimerClass;
    private TextView tvSearchBy,tvDate,tvSetDate,tvSelectCategory,tvCategory,tvHeader;
    private List<AttractionModel> attractionModels=new ArrayList<>();
    private String[] fitness_name=new String[]{"Bootcamp Pilates","Triyoga","Lomax",
            "Duo","Bootcamp Pilates","Evolve Wellness Centre","Core","Equilibrium","SW1 Fitness","Bootcamp Pilates","YMCA","Bootcamp Pilates"};
    private String[] fitness_category=new String[]{"Pilates","Yoga","Health Club","Pilates","Pilates","Yoga",
            "Pilates","Total Balance","Box Fit","Pilates","Health Club","Pilates"};
    private String[] fitness_location=new String[]{"Notting Hill","Chelsea","Chelsea","Chelsea",
            "Fulham","Kensington","Kensington","Holland Park","Belgravia","Mayfair","Fitzrovia","Richmond"};
    private int[] fitness_image=new int[]{R.drawable.img5,R.drawable.img3,R.drawable.img1,
            R.drawable.img11,R.drawable.img8,R.drawable.img10,R.drawable.img7,R.drawable.img4,R.drawable.img6,
            R.drawable.img9,R.drawable.img2,R.drawable.img12};
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_category);
        getIds();
        setListeners();
        setRecycle();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();
    }
    private void getIds() {
        rvFitness = (RecyclerView) findViewById(R.id.rvFitness);
        llCategory = (LinearLayout) findViewById(R.id.llCategory);
        llDate = (LinearLayout) findViewById(R.id.llDate);
        tvHeader = (TextView) findViewById(R.id.tvHeader);
        tvSearchBy = (TextView) findViewById(R.id.tvSearchBy);
        tvDate = (TextView) findViewById(R.id.tvDate);
        tvSetDate = (TextView) findViewById(R.id.tvSetDate);
        tvSelectCategory = (TextView) findViewById(R.id.tvSelectCategory);
        tvCategory = (TextView) findViewById(R.id.tvCategory);
        for (int i = 0; i < fitness_name.length; i++) {
            AttractionModel attractionModel = new AttractionModel();
            attractionModel.setAttraction_image(fitness_image[i]);
            attractionModel.setAttraction_name(fitness_name[i]);
            attractionModel.setAttraction_category(fitness_category[i]);
            attractionModel.setAttraction_location(fitness_location[i]);
            attractionModels.add(attractionModel);

        }

    }
    private void setListeners()
    {
        llCategory.setOnClickListener(this);
        llDate.setOnClickListener(this);
        rvFitness.setOnClickListener(this);
    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvHeader.setTypeface(typefaceBold);
        tvSearchBy.setTypeface(typeface);
        tvDate.setTypeface(typeface);
        tvSetDate.setTypeface(typeface);
        tvSelectCategory.setTypeface(typeface);
        tvCategory.setTypeface(typeface);


    }

    private void setRecycle() {
        gridLayoutManager = new GridLayoutManager(mContext, 2, LinearLayoutManager.HORIZONTAL, false);
        rvFitness.setLayoutManager(gridLayoutManager);
        selectCategoryFitnessAdapter = new SelectFitnessCategoryAdapter(mContext,attractionModels);
        rvFitness.setAdapter(selectCategoryFitnessAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId())
        {
            case R.id.llCategory:
                Toast.makeText(mContext,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.llDate:
            Toast.makeText(mContext,"Work in progress.",Toast.LENGTH_SHORT).show();
            break;
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
