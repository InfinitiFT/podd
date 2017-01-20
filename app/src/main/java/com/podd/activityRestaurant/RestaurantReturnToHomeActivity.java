package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.activityTaxi.HomeScreenActivity;
import com.podd.utils.AppConstant;

/**
 * The type Restaurant return to home activity.
 */
public class RestaurantReturnToHomeActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvReturnToHome;
    private Context context;
    private Intent intent;
    private TextView tvRestauarntName;
    private TextView tvLocation;
    private TextView tvDateBooked;
    private TextView tvTimeBooked;
    private TextView tvNumberofPeople;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_return_to_home);
        context = RestaurantReturnToHomeActivity.this;
        getIds();
        setListeners();
        if(getIntent()!=null) {
            String restaurantName = getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
            String restaurantId = getIntent().getStringExtra(AppConstant.RESTAURANTID);
            String dateBooked = getIntent().getStringExtra(AppConstant.DATEBOOKED);
            String timeBooked = getIntent().getStringExtra(AppConstant.TIMEBOOKED);
            String location = getIntent().getStringExtra(AppConstant.LOCATION);
            String noOfPersons = getIntent().getStringExtra(AppConstant.NOOFPEOPLE);

            tvRestauarntName.setText(restaurantName);
            tvLocation.setText(location);
            tvTimeBooked.setText(timeBooked);
            tvDateBooked.setText(dateBooked);
            tvNumberofPeople.setText(noOfPersons);
        }


    }

    private void getIds() {
        tvReturnToHome = (TextView) findViewById(R.id.tvReturnToHome);
        tvRestauarntName = (TextView) findViewById(R.id.tvRestauarntName);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvDateBooked = (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked = (TextView) findViewById(R.id.tvTimeBooked);
        tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);

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
        tvReturnToHome.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvReturnToHome:
                intent = new Intent(context, NewHomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        intent = new Intent(context, NewHomeScreenActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
    }


}
