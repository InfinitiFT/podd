package com.podd.fragment;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import com.podd.R;


@SuppressWarnings("ALL")
public class DinnerMenuFragment extends Fragment {


    private Context context;
    private View view;
    private RecyclerView rvBreakfastMenu;


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        this.context = context;
    }

    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_breakfast_menu, container, false);
        getIds();
        setBreakfastMenu();
        return view;
    }

    private void getIds() {
        rvBreakfastMenu= (RecyclerView) view.findViewById(R.id.rvBreakfastMenu);

    }

    private void setBreakfastMenu() {
       /* LunchMenuAdapter lunchMenuAdapter = new LunchMenuAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context);
        rvBreakfastMenu.setLayoutManager(mLayoutManager);
        rvBreakfastMenu.setAdapter(lunchMenuAdapter);*/
    }

}
