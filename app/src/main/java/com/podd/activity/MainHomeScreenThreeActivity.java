package com.podd.activity;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;

public class MainHomeScreenThreeActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvBookTaxi;
    private TextView tvGoingSomewhere;
    private ImageView ivTaxi;
    private Context context;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_home_screen_three);
        context=MainHomeScreenThreeActivity.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvBookTaxi= (TextView) findViewById(R.id.tvBookTaxi);
        tvGoingSomewhere= (TextView) findViewById(R.id.tvGoingSomewhere);
        ivTaxi= (ImageView) findViewById(R.id.ivTaxi);
        ImageView ivHeader= (ImageView) findViewById(R.id.ivHeader);
    }

    private void setListeners() {
        tvBookTaxi.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookTaxi:
                Toast.makeText(context,"Work in progress.",Toast.LENGTH_SHORT).show();
                break;
        }
    }
}
