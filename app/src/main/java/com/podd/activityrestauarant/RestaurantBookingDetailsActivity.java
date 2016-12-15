package com.podd.activityrestauarant;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;

/**
 * The type Restraunt booking details activity.
 */
public class RestaurantBookingDetailsActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private RecyclerView rvRestaurants;
    private TextView tvBookNow;
    private Intent intent;
    private Spinner spSelectTime;
    private Spinner spSelectPeople;
    private TextView tvSelectfromCalender;
    private TextView tvRestauarntName;
    private TextView tvDate;
    private TextView tvToday;
    private TextView tvTomorrow;
    private TextView tvTime;
    private TextView tvBookingSummary;
    private TextView tvDateBooked;
    private TextView tvTimeBooked;
    private TextView tvNoOfPersons;

    private final String[]timeArray={"Select Time","10 AM","10:30 AM"};
    private final String[]numberOfPeopleArray={"Select Number of People","1","2","3"};

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restraunt_booking_details);
        context=RestaurantBookingDetailsActivity.this;
        getIds();
        setListeners();
        selectTimeAdapter();
        selectNumberOfPeopleAdapter();
        setAdapter();
    }

    private void getIds() {
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        tvSelectfromCalender= (TextView) findViewById(R.id.tvSelectfromCalender);
        spSelectTime= (Spinner) findViewById(R.id.spSelectTime);
        spSelectPeople= (Spinner) findViewById(R.id.spSelectPeople);
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvDate= (TextView) findViewById(R.id.tvDate);
        tvToday= (TextView) findViewById(R.id.tvToday);
        tvTomorrow= (TextView) findViewById(R.id.tvTomorrow);
        tvTime= (TextView) findViewById(R.id.tvTime);
        tvBookingSummary= (TextView) findViewById(R.id.tvBookingSummary);
        tvDateBooked= (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked= (TextView) findViewById(R.id.tvTimeBooked);
        tvNoOfPersons= (TextView) findViewById(R.id.tvNoOfPersons);


        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

    }
    private void selectTimeAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,timeArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectTime.setAdapter(adapter);
    }
    private void selectNumberOfPeopleAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,numberOfPeopleArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectPeople.setAdapter(adapter);
    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
        tvSelectfromCalender.setOnClickListener(this);

    }

    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                intent=new Intent(context,BookingSummaryActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
            case R.id.tvSelectfromCalender:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;

        }
    }
}
