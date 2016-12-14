package com.podd.activitytaxi;

import android.content.Context;
import android.content.Intent;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;

public class BookTaxiActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private Spinner spSelectAirport;
    private Spinner spSelectTime;
    private Spinner spSelectPeople;
    private Spinner spSelectAdditionalRequirement;
    private TextView tvBookTaxi;
    private TextView tvBookNow;
    private TextView tvadditionalRequirements;
    private TextView tvSelectPeople;
    private TextView tvTime;
    private TextView tvSelectfromCalender;
    private TextView tvTomorrow;
    private TextView tvToday;
    private TextView tvDate;
    private TextView tvGoingTo;
    private TextView tvLeavingFrom;
    private EditText etLeavingAddress;
    private EditText etGoingAddress;
    private LinearLayout llInner;
    private final String[]airportArray={"Select Airport","Newyork","Others"};
    private final String[]timeArray={"Select Time","10 AM","10:30 AM"};
    private final String[]numberOfPeopleArray={"Select Nember of People","1","2","3"};
    private final String[]requirementsArray={"Select Additional Requirements","AC","Others"};
    private TextView tvBack;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_book_taxi);
        context=BookTaxiActivity.this;
        getIds();
        selectAdditionalRequirementsAdapter();
        selectAirportAdapter();
        selectNumberOfPeopleAdapter();
        selectTimeAdapter();
        setListeners();
    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
        tvBack.setOnClickListener(this);


    }

    private void getIds() {
        spSelectAirport= (Spinner) findViewById(R.id.spSelectAirport);
        spSelectAdditionalRequirement= (Spinner) findViewById(R.id.spSelectAdditionalRequirement);
        spSelectPeople= (Spinner) findViewById(R.id.spSelectPeople);
        spSelectTime= (Spinner) findViewById(R.id.spSelectTime);
        etGoingAddress= (EditText) findViewById(R.id.etGoingAddress);
        etLeavingAddress= (EditText) findViewById(R.id.etLeavingAddress);
        tvLeavingFrom= (TextView) findViewById(R.id.tvLeavingFrom);
        tvGoingTo= (TextView) findViewById(R.id.tvGoingTo);
        tvDate= (TextView) findViewById(R.id.tvDate);
        tvToday= (TextView) findViewById(R.id.tvToday);
        tvTomorrow= (TextView) findViewById(R.id.tvTomorrow);
        tvSelectfromCalender= (TextView) findViewById(R.id.tvSelectfromCalender);
        tvTime= (TextView) findViewById(R.id.tvTime);
        tvSelectPeople= (TextView) findViewById(R.id.tvSelectPeople);
        tvadditionalRequirements= (TextView) findViewById(R.id.tvadditionalRequirements);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        tvBookTaxi= (TextView) findViewById(R.id.tvBookTaxi);
        llInner= (LinearLayout) findViewById(R.id.llInner);
        tvBack= (TextView) findViewById(R.id.tvBack);
        tvBack.setVisibility(View.VISIBLE);
    }


    private void selectAirportAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,airportArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectAirport.setAdapter(adapter);
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
    private void selectAdditionalRequirementsAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,requirementsArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectAdditionalRequirement.setAdapter(adapter);
    }


    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                if (isValid()) {
                    Intent intent=new Intent(context,TaxiBookingSummaryActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }
                break;
            case R.id.tvBack:
                Intent intent=new Intent(context,HomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;



        }
    }

    private boolean isValid(){
        if(etLeavingAddress.getText().toString().isEmpty()){
            Snackbar.make(llInner,R.string.please_enter_leaving_address,Snackbar.LENGTH_SHORT).show();
            etLeavingAddress.requestFocus();
            return false;
        }
        else if (etGoingAddress.getText().toString().isEmpty()){
            Snackbar.make(llInner,R.string.please_enter_going_address,Snackbar.LENGTH_SHORT).show();
            etGoingAddress.requestFocus();
            return false;
        }

        return true;
    }
}
