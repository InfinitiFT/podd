package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.podd.R;


/**
 * The type Main home screen three activity.
 */
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

    }

    private void setListeners() {
        tvBookTaxi.setOnClickListener(this);


    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookTaxi:
                Intent intent=new Intent(context,BookTaxiActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }
}
