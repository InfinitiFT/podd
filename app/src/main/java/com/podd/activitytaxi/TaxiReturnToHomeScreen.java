package com.podd.activitytaxi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.podd.R;

/**
 * The type Taxi return to home screen.
 */
public class TaxiReturnToHomeScreen extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private TextView tvThanks;
    private TextView tvConfirmation;
    private TextView tvadditionalInfo;
    private TextView tvNumberofPeople;
    private TextView tvTime;
    private TextView tvDate;
    private TextView tvGoingTo;
    private TextView tvLeavingFrom;
    private LinearLayout llInner;
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
        tvLeavingFrom= (TextView) findViewById(R.id.tvLeavingFrom);
        tvGoingTo= (TextView) findViewById(R.id.tvGoingTo);
        tvDate= (TextView) findViewById(R.id.tvDate);
        tvTime= (TextView) findViewById(R.id.tvTime);
        tvNumberofPeople= (TextView) findViewById(R.id.tvNumberofPeople);
        tvadditionalInfo= (TextView) findViewById(R.id.tvadditionalInfo);
        tvConfirmation= (TextView) findViewById(R.id.tvConfirmation);
        tvThanks= (TextView) findViewById(R.id.tvThanks);
        llInner= (LinearLayout) findViewById(R.id.llInner);

    }

    private void setListeners() {
        tvReturnToHome.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvReturnToHome:
                Intent intent=new Intent(context,HomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;

        }

    }
}
