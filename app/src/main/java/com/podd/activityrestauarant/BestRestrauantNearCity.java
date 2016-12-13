package com.podd.activityrestauarant;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;

import com.podd.R;
import com.podd.adapter.BestRestrauantAdapter;

public class BestRestrauantNearCity extends AppCompatActivity {

    private RecyclerView rvRestaurants;
    private Context context;
    private BestRestrauantAdapter bestRestrauantAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restrauant_near_city);
        context=BestRestrauantNearCity.this;
        getIds();
        setListeners();
    }

    private void setListeners() {

    }

    private void getIds() {
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);

    }

    private void setRecycler() {
        GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2);
        rvRestaurants.setLayoutManager(gridLayoutManager);
        bestRestrauantAdapter = new BestRestrauantAdapter(context);
        rvRestaurants.setAdapter(bestRestrauantAdapter);
        rvRestaurants.setNestedScrollingEnabled(false);
    }
}
