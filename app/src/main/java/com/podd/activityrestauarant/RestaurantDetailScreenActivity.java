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
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;


/**
 * The type Restaurant detail screen activity.
 */
public class RestaurantDetailScreenActivity extends AppCompatActivity implements View.OnClickListener {

    private TextView tvRestauarntName;
    private TextView tvNameRestaraunt;
    private TextView tvCategory;
    private TextView tvPriceRange;
    private TextView tvLocation;
    private TextView tvDistance;
    private TextView tvBookNow;
    private TextView tvAboutRestaurant;
    private TextView tvDescriptionRestaraunt;
    private TextView tvViewMenu;
    private TextView tvViewInMap;
    private LinearLayout llInner;
    private LinearLayout llButtons;
    private LinearLayout llDistance;
    private LinearLayout llLocation;
    private LinearLayout llPriceRange;
    private LinearLayout llCategory;
    private LinearLayout llRestaurantName;
    private RecyclerView rvRestaurants;
    private Context context;
    private Intent intent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_detail_screen);
        context=RestaurantDetailScreenActivity.this;
        getIds();
        setListeners();
        setAdapter();
    }

    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    private void getIds() {
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvNameRestaraunt= (TextView) findViewById(R.id.tvNameRestaraunt);
        tvCategory= (TextView) findViewById(R.id.tvCategory);
        tvPriceRange= (TextView) findViewById(R.id.tvPriceRange);
        tvLocation= (TextView) findViewById(R.id.tvLocation);
        tvDistance= (TextView) findViewById(R.id.tvDistance);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        tvAboutRestaurant= (TextView) findViewById(R.id.tvAboutRestaurant);
        tvDescriptionRestaraunt= (TextView) findViewById(R.id.tvDescriptionRestaraunt);
        tvViewMenu= (TextView) findViewById(R.id.tvViewMenu);
        tvViewInMap= (TextView) findViewById(R.id.tvViewInMap);
        llInner= (LinearLayout) findViewById(R.id.llInner);
        llButtons= (LinearLayout) findViewById(R.id.llButtons);
        llDistance= (LinearLayout) findViewById(R.id.llDistance);
        llLocation= (LinearLayout) findViewById(R.id.llLocation);
        llPriceRange= (LinearLayout) findViewById(R.id.llPriceRange);
        llCategory= (LinearLayout) findViewById(R.id.llCategory);
        llRestaurantName= (LinearLayout) findViewById(R.id.llRestaurantName);
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);


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
        tvViewMenu.setOnClickListener(this);
        tvViewInMap.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                intent=new Intent(context,RestaurantBookingDetailsActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
            case R.id.tvViewMenu:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.tvViewInMap:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;


        }

    }
}
