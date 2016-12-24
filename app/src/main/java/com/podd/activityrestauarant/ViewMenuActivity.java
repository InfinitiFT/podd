package com.podd.activityrestauarant;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.podd.R;
import com.podd.adapter.LunchMenuAdapter;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.utils.AppConstant;

import java.util.ArrayList;

/**
 * The type View menu activity.
 */
public class ViewMenuActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private RecyclerView rvDinner;
    private TextView tvDinner;
    private LinearLayout llDinner;
    private RecyclerView rvLunchMenu;
    private TextView tvLunchMenu;
    private LinearLayout llLunch;
    private RecyclerView rvBreakfastMenu;
    private TextView tvBreakfastMenu;
    private LinearLayout llBreakfast;
    private RecyclerView rvRestaurants;
    private TextView tvRestauarntName;
    private TextView tvBookNow;
    private Intent intent;
    private ArrayList<String> restaurantImages;
    private String restaurantName;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_menu);
        context=ViewMenuActivity.this;
        getIds();
        setListeners();
        restaurantImages = (ArrayList<String>) getIntent().getSerializableExtra(AppConstant.RESTAURANTIMAGES);
        restaurantName=getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
        tvRestauarntName.setText(restaurantName);
        setAdapter();
        setLunchMenuAdapter();
        setBreakfastMenu();
        setDinnerMenu();
    }

    private void getIds() {
        rvDinner= (RecyclerView) findViewById(R.id.rvDinner);
        rvLunchMenu= (RecyclerView) findViewById(R.id.rvLunchMenu);
        rvBreakfastMenu= (RecyclerView) findViewById(R.id.rvBreakfastMenu);
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        tvDinner= (TextView) findViewById(R.id.tvDinner);
        tvLunchMenu= (TextView) findViewById(R.id.tvLunchMenu);
        tvBreakfastMenu= (TextView) findViewById(R.id.tvBreakfastMenu);
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        llDinner= (LinearLayout) findViewById(R.id.llDinner);
        llLunch= (LinearLayout) findViewById(R.id.llLunch);
        llBreakfast= (LinearLayout) findViewById(R.id.llBreakfast);


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

    private void setListeners() {
        tvBookNow.setOnClickListener(this);

    }


    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context,restaurantImages);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    private void setLunchMenuAdapter() {
        LunchMenuAdapter lunchMenuAdapter = new LunchMenuAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context);
        rvLunchMenu.setLayoutManager(mLayoutManager);
        rvLunchMenu.setAdapter(lunchMenuAdapter);
    }

    private void setBreakfastMenu() {
        LunchMenuAdapter lunchMenuAdapter = new LunchMenuAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context);
        rvBreakfastMenu.setLayoutManager(mLayoutManager);
        rvBreakfastMenu.setAdapter(lunchMenuAdapter);
    }

    private void setDinnerMenu() {
        LunchMenuAdapter lunchMenuAdapter = new LunchMenuAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context);
        rvDinner.setLayoutManager(mLayoutManager);
        rvDinner.setAdapter(lunchMenuAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                intent=new Intent(context,RestaurantBookingDetailsActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;

        }
    }
}
