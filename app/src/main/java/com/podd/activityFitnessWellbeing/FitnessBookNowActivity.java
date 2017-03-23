package com.podd.activityFitnessWellbeing;

import android.content.Context;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.AirprotHeaderImageAdapter;
import com.podd.adapter.FitnessHeaderImageAdapter;
import com.podd.model.HomeItemsModel;
import com.podd.utils.SetTimerClass;

import java.util.ArrayList;
import java.util.List;


public class FitnessBookNowActivity extends AppCompatActivity implements View.OnClickListener {
    private Context mContext= FitnessBookNowActivity.this;
    private SetTimerClass setTimerClass;
    private RecyclerView rvHeaderImage;
    private FitnessHeaderImageAdapter fitnessHeaderImageAdapter;
    private TextView tvBookNow;
    private List<HomeItemsModel> homeItemsModelList = new ArrayList<>();
    private  int[] img = new int[]{R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1,R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1,R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1};
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fitness_book_now);
        getIds();
        setFont();
        setListeners();
        setRecycler();
        setTimerClass = (SetTimerClass)getApplication();
        for (int i = 0; i < img.length; i++) {
            HomeItemsModel hotelItemModel = new HomeItemsModel();
            hotelItemModel.setImage(img[i]);
            homeItemsModelList.add(hotelItemModel);
        }

    }
    private void setRecycler() {
        fitnessHeaderImageAdapter = new FitnessHeaderImageAdapter(mContext,homeItemsModelList);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(mContext,LinearLayoutManager.HORIZONTAL,false);
        rvHeaderImage.setLayoutManager(mLayoutManager);
        rvHeaderImage.setAdapter(fitnessHeaderImageAdapter);
    }
    private void getIds() {
        rvHeaderImage = (RecyclerView) findViewById(R.id.rvHeaderImage);
        tvBookNow = (TextView) findViewById(R.id.tvBookNow);
    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvBookNow.setTypeface(typefaceBold);
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
    private void setListeners() {
        tvBookNow.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                Toast.makeText(mContext,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;

        }

    }

}
