package com.podd.activity;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;


public class HomeScreenActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private TextView tvDiscoverLondon;
    private TextView tvServicedApartment;
    private TextView tvStayLondon;
    private TextView tvFood;
    private TextView tvTaxi;
    private TextView tvHealth;
    private TextView tvHappeningInLondon;
    private LinearLayout llHappening;
    private LinearLayout llHealth;
    private LinearLayout llTaxi;
    private LinearLayout llFood;
    private ImageView ivFood;
    private ImageView ivTaxi;
    private ImageView ivHealth;
    private ImageView ivHappeningInLondon;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home_screen);
        context=HomeScreenActivity.this;
        getIds();
        setListeners();
    }

    private void setListeners() {
        llFood.setOnClickListener(this);
        llTaxi.setOnClickListener(this);

    }

    private void getIds() {
        tvDiscoverLondon= (TextView) findViewById(R.id.tvDiscoverLondon);
        tvServicedApartment= (TextView) findViewById(R.id.tvServicedApartment);
        tvStayLondon= (TextView) findViewById(R.id.tvStayLondon);
        tvFood= (TextView) findViewById(R.id.tvFood);
        tvTaxi= (TextView) findViewById(R.id.tvTaxi);
        tvHealth= (TextView) findViewById(R.id.tvHealth);
        tvHappeningInLondon= (TextView) findViewById(R.id.tvHappeningInLondon);
        llHappening= (LinearLayout) findViewById(R.id.llHappening);
        llHealth= (LinearLayout) findViewById(R.id.llHealth);
        llTaxi= (LinearLayout) findViewById(R.id.llTaxi);
        llFood= (LinearLayout) findViewById(R.id.llfood);
        ivFood= (ImageView) findViewById(R.id.ivfood);
        ivTaxi= (ImageView) findViewById(R.id.ivTaxi);
        ivHealth= (ImageView) findViewById(R.id.ivHealth);
        ivHappeningInLondon= (ImageView) findViewById(R.id.ivHappeningInLondon);
        ImageView ivHeader= (ImageView) findViewById(R.id.ivHeader);


    }

    @Override
    public void onClick(View view) {

        switch (view.getId()){
            case R.id.llfood:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
            case R.id.llTaxi:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
        }

    }
}
