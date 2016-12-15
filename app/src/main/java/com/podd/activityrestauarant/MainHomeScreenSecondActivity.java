package com.podd.activityrestauarant;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;

/**
 * The type Main home screen second activity.
 */
public class MainHomeScreenSecondActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvDiscoverRestaurantsBars;
    private TextView tvViewAndBook;
    private LinearLayout llStarRestaurants;
    private LinearLayout llCasualEats;
    private LinearLayout llLateNightVenues;
    private LinearLayout llMealsDelivered;
    private LinearLayout llInner;
    private Context context;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_home_screen_second);
        context=MainHomeScreenSecondActivity.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvDiscoverRestaurantsBars= (TextView) findViewById(R.id.tvDiscoverRestaurantsBars);
        tvViewAndBook= (TextView) findViewById(R.id.tvViewAndBook);
        llStarRestaurants= (LinearLayout) findViewById(R.id.llStarRestaurants);
        llCasualEats= (LinearLayout) findViewById(R.id.llCasualEats);
        llMealsDelivered= (LinearLayout) findViewById(R.id.llMealsDelivered);
        llLateNightVenues= (LinearLayout) findViewById(R.id.llLateNightVenues);
        llInner= (LinearLayout) findViewById(R.id.llInner);



    }

    private void setListeners() {
        llStarRestaurants.setOnClickListener(this);
        llCasualEats.setOnClickListener(this);
        llLateNightVenues.setOnClickListener(this);
        llMealsDelivered.setOnClickListener(this);
        tvViewAndBook.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.llStarRestaurants:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.llCasualEats:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.llMealsDelivered:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.llLateNightVenues:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.tvViewAndBook:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;

        }

    }
}
