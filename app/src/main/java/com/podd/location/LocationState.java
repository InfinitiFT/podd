package com.podd.location;

import org.json.JSONObject;


public abstract class LocationState {
    public abstract  void onSuccess(JSONObject response);
}
