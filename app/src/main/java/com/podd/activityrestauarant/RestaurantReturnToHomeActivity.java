package com.podd.activityrestauarant;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.activitytaxi.HomeScreenActivity;

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
    private TextView tvConfirmation;
    private TextView tvThanks;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_return_to_home);
        context=RestaurantReturnToHomeActivity.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvReturnToHome= (TextView) findViewById(R.id.tvReturnToHome);
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvLocation= (TextView) findViewById(R.id.tvLocation);
        tvDateBooked= (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked= (TextView) findViewById(R.id.tvTimeBooked);
        tvNumberofPeople= (TextView) findViewById(R.id.tvNumberofPeople);
        tvConfirmation= (TextView) findViewById(R.id.tvConfirmation);
        tvThanks= (TextView) findViewById(R.id.tvThanks);


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
        switch (view.getId()){
            case R.id.tvReturnToHome:
                intent=new Intent(context, HomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }
}