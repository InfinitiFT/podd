package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.podd.R;
import com.podd.activityRestaurant.NewHomeScreenActivity;

/**
 * The type Taxi return to home screen.
 */
public class TaxiReturnToHomeScreen extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private TextView tvReturnToHome;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_taxi_return_home);
        context=TaxiReturnToHomeScreen.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvReturnToHome= (TextView) findViewById(R.id.tvReturnToHome);
        TextView tvLeavingFrom = (TextView) findViewById(R.id.tvLeavingFrom);
        TextView tvGoingTo = (TextView) findViewById(R.id.tvGoingTo);
        TextView tvDate = (TextView) findViewById(R.id.tvDate);
        TextView tvTime = (TextView) findViewById(R.id.tvTime);
        TextView tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);
        TextView tvadditionalInfo = (TextView) findViewById(R.id.tvadditionalInfo);
        TextView tvConfirmation = (TextView) findViewById(R.id.tvConfirmation);
        TextView tvThanks = (TextView) findViewById(R.id.tvThanks);
        LinearLayout llInner = (LinearLayout) findViewById(R.id.llInner);

    }

    private void setListeners() {
        tvReturnToHome.setOnClickListener(this);


    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvReturnToHome:
                Intent intent=new Intent(context,NewHomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;

        }

    }
}
