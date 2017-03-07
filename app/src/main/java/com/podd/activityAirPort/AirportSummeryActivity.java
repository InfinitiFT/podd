package com.podd.activityAirPort;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.activityRestaurant.NewHomeScreenActivity;
import com.podd.utils.SetTimerClass;

/**
 * Created by Raj Kumar on 3/7/2017
 * for Mobiloitte
 */

public class AirportSummeryActivity extends AppCompatActivity implements View.OnClickListener {
  private Context mContext=AirportSummeryActivity.this;
    private TextView tvReturnToHome,tvHeader;
    private Intent intent;
    private SetTimerClass setTimerClass;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_airport_summery);
        getID();
        setFont();
        setListeners();
        setTimerClass = (SetTimerClass)getApplication();
    }

    private void setFont() {
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");

        tvHeader.setTypeface(typefaceBold);
    }

    private void getID() {
        tvReturnToHome=(TextView)findViewById(R.id.tvReturnToHome);
        tvHeader=(TextView)findViewById(R.id.tvHeader);

    }  private void setListeners() {
        tvReturnToHome.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvReturnToHome:
                SetTimerClass.savedList.clear();
                intent = new Intent(mContext, NewHomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        SetTimerClass.savedList.clear();
        intent = new Intent(mContext, NewHomeScreenActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
    }

    @Override
    protected void onResume() {
        super.onResume();
        setTimerClass.setTimer(this, true);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        setTimerClass.setTimer(this, true);
    }

    @Override
    public void onUserInteraction() {
        super.onUserInteraction();
        setTimerClass.setTimer(this, false);
    }

}
