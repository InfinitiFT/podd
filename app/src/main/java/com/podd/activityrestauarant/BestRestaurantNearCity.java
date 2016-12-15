package com.podd.activityrestauarant;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.BestRestaurantAdapter;

/**
 * The type Best restaurant near city.
 */
public class BestRestaurantNearCity extends AppCompatActivity implements View.OnClickListener {

    private RecyclerView rvRestaurants;
    private Context context;
    private BestRestaurantAdapter bestRestaurantAdapter;
    private TextView tvDeliveredtoYou;
    private TextView tvBusiness;
    private TextView tvAmbience;
    private TextView tvMealType;
    private TextView tvMeal;
    private TextView tvCuisinetype;
    private TextView tvCuisine;
    private TextView tvDietary;
    private TextView tvLocationType;
    private TextView tvLocation;
    private TextView tvDietaryType;
    private TextView tvSearchBy;
    private TextView tvCityName;
    private TextView tvNearbyRestaurant;
    private LinearLayout llLocation;
    private LinearLayout llDietary;
    private LinearLayout llCuisine;
    private LinearLayout llMeal;
    private LinearLayout llAmbience;
    private LinearLayout llDeliveredToYou;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restaurant_near_city);
        context=BestRestaurantNearCity.this;
        getIds();
        setListeners();
        setRecycler();
    }

    private void setListeners() {
        llDeliveredToYou.setOnClickListener(this);
        llAmbience.setOnClickListener(this);
        llMeal.setOnClickListener(this);
        llCuisine.setOnClickListener(this);
        llDietary.setOnClickListener(this);
        llLocation.setOnClickListener(this);

    }

    private void getIds() {
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        llDeliveredToYou= (LinearLayout) findViewById(R.id.llDeliveredToYou);
        llAmbience= (LinearLayout) findViewById(R.id.llAmbience);
        llMeal= (LinearLayout) findViewById(R.id.llMeal);
        llCuisine= (LinearLayout) findViewById(R.id.llCuisine);
        llDietary= (LinearLayout) findViewById(R.id.llDietary);
        llLocation= (LinearLayout) findViewById(R.id.llLocation);
        tvNearbyRestaurant= (TextView) findViewById(R.id.tvNearbyRestaurant);
        tvCityName= (TextView) findViewById(R.id.tvCityName);
        tvSearchBy= (TextView) findViewById(R.id.tvSearchBy);
        tvDietaryType= (TextView) findViewById(R.id.tvDietaryType);
        tvLocation= (TextView) findViewById(R.id.tvLocation);
        tvLocationType= (TextView) findViewById(R.id.tvLocationType);
        tvDietary= (TextView) findViewById(R.id.tvDietary);
        tvCuisine= (TextView) findViewById(R.id.tvCuisine);
        tvCuisinetype= (TextView) findViewById(R.id.tvCuisinetype);
        tvMeal= (TextView) findViewById(R.id.tvMeal);
        tvMealType= (TextView) findViewById(R.id.tvMealType);
        tvAmbience= (TextView) findViewById(R.id.tvAmbience);
        tvBusiness= (TextView) findViewById(R.id.tvBusiness);
        tvDeliveredtoYou= (TextView) findViewById(R.id.tvDeliveredtoYou);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

    }

    private void setRecycler() {
        GridLayoutManager gridLayoutManager = new GridLayoutManager(context,2,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(gridLayoutManager);
        bestRestaurantAdapter = new BestRestaurantAdapter(context);
        rvRestaurants.setAdapter(bestRestaurantAdapter);
        rvRestaurants.setNestedScrollingEnabled(false);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.llAmbience:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llLocation:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llDietary:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llCuisine:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llMeal:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llDeliveredToYou:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;

        }

    }
}
