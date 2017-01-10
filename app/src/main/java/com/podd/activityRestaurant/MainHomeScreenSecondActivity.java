package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;
import com.podd.R;
import com.podd.adapter.RestaurantsListAdapter;

/**
 * The type Main home screen second activity.
 */
public class MainHomeScreenSecondActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvDiscoverRestaurantsBars;
    private TextView tvViewAndBook;
    private Context context;
    private RecyclerView rvRestaurantsList;
    private Intent intent;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_home_screen_second);
        context=MainHomeScreenSecondActivity.this;
        getIds();
        setListeners();
        setAdapter();
    }

    private void getIds() {
        tvDiscoverRestaurantsBars= (TextView) findViewById(R.id.tvDiscoverRestaurantsBars);
        tvViewAndBook= (TextView) findViewById(R.id.tvViewAndBook);
        rvRestaurantsList= (RecyclerView) findViewById(R.id.rvRestaurantsList);


    }

    private void setListeners() {
        tvViewAndBook.setOnClickListener(this);

    }

    private void setAdapter() {
        RestaurantsListAdapter restaurantsListAdapter = new RestaurantsListAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurantsList.setLayoutManager(mLayoutManager);
        rvRestaurantsList.setAdapter(restaurantsListAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvViewAndBook:
                intent=new Intent(context, BestRestaurantNearCity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);

        }

    }
}
