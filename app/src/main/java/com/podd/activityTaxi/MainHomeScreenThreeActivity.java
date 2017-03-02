package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.hailoTaxi.HailoDrivers;
import com.podd.hailoTaxi.HailoETA;
import com.podd.hailoTaxi.HailoResponse;
import com.podd.hailoTaxi.ListViewModel;
import com.podd.hailoTaxi.TaxiServiceAsync;
import com.podd.hailoTaxi.TaxiWebServiceStatus;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;

import java.util.ArrayList;
import java.util.List;


/**
 * The type Main home screen three activity.
 */
public class MainHomeScreenThreeActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvBookTaxi;
    private TextView tvHailo;
    private Context context;
    private List<ListViewModel> list = new ArrayList<>();
    private Intent intent;

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
        tvHailo= (TextView) findViewById(R.id.tvHailo);
        TextView tvGoingSomewhere = (TextView) findViewById(R.id.tvGoingSomewhere);
        ImageView ivTaxi = (ImageView) findViewById(R.id.ivTaxi);

    }

    private void setListeners() {
        tvBookTaxi.setOnClickListener(this);
        tvHailo.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookTaxi:
                intent=new Intent(context,BookTaxiActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);

                break;
            case R.id.tvHailo:
                intent=new Intent(context,HailoActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }

}
