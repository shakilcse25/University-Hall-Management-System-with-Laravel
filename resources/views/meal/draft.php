                <div class="all_action" style="margin-bottom:20px;margin-top:20px;border-bottom: 2px solid #80808042;display:flow-root;">
                    <form id="searchmeal" action="{{route('search.mealstudent',['id'=>$id])}}" method="POST" style="display:flex;align-item:center;padding:8px 0px;border-bottom:2px solid #80808042;margin-bottom:10px;" enctype="multipart/form-data">
                        <div class="inner" style="margin:0px auto;display:flex;align-items:center;">
                            @csrf

                            <select onchange="searchsubmit();" name="floor[]" style="width: 270px !important;margin-right: 40px;display:inline-block;" class="select2_multiple form-control" multiple="multiple">
                                <option disabled value="">Select Floor</option>
                                <option <?php if (in_array('allroom', $search)) echo 'selected'; ?> value="allroom">All</option>
                                <option <?php if (in_array('1', $search)) echo 'selected'; ?> value="1">1st</option>
                                <option <?php if (in_array('2', $search)) echo 'selected'; ?> value="2">2nd</option>
                                <option <?php if (in_array('3', $search)) echo 'selected'; ?> value="3">3rd</option>
                                <option <?php if (in_array('4', $search)) echo 'selected'; ?> value="4">4th</option>
                                <option <?php if (in_array('5', $search)) echo 'selected'; ?> value="5">5th</option>
                                <option <?php if (in_array('6', $search)) echo 'selected'; ?> value="6">6th</option>
                                <option <?php if (in_array('7', $search)) echo 'selected'; ?> value="7">7th</option>
                                <option <?php if (in_array('8', $search)) echo 'selected'; ?> value="8">8th</option>
                                <option <?php if (in_array('9', $search)) echo 'selected'; ?> value="9">9th</option>
                                <option <?php if (in_array('10', $search)) echo 'selected'; ?> value="10">10th</option>
                                <option <?php if (in_array('11', $search)) echo 'selected'; ?> value="11">11th</option>
                                <option <?php if (in_array('12', $search)) echo 'selected'; ?> value="12">12th</option>
                            </select>

                            <select onchange="searchsubmit();" name="batch[]" style="width: 270px !important;margin-right: 40px;display:inline-block;" class="select2_multiple form-control" multiple="multiple">
                                <option disabled value="">Select Batch</option>
                                <option <?php if (in_array('allbatch', $search)) echo 'selected'; ?> value="allbatch">All</option>
                                <option <?php if (in_array('1st', $search)) echo 'selected'; ?> value="1st">1st</option>
                                <option <?php if (in_array('2nd', $search)) echo 'selected'; ?> value="2nd">2nd</option>
                                <option <?php if (in_array('3rd', $search)) echo 'selected'; ?> value="3rd">3rd</option>
                                <option <?php if (in_array('4th', $search)) echo 'selected'; ?> value="4th">4th</option>
                                <option <?php if (in_array('5th', $search)) echo 'selected'; ?> value="5th">5th</option>
                                <option <?php if (in_array('6th', $search)) echo 'selected'; ?> value="6th">6th</option>
                                <option <?php if (in_array('7th', $search)) echo 'selected'; ?> value="7th">7th</option>
                                <option <?php if (in_array('8th', $search)) echo 'selected'; ?> value="8th">8th</option>
                                <option <?php if (in_array('9th', $search)) echo 'selected'; ?> value="9th">9th</option>
                                <option <?php if (in_array('10th', $search)) echo 'selected'; ?> value="10th">10th</option>
                                <option <?php if (in_array('11th', $search)) echo 'selected'; ?> value="11th">11th</option>
                                <option <?php if (in_array('12th', $search)) echo 'selected'; ?> value="12th">12th</option>
                            </select>

                            <select onchange="searchsubmit();" name="dept[]" style="width: 270px !important;margin-right: 40px;display:inline-block;" class="select2_multiple form-control" multiple="multiple">
                                <option disabled value="">Select Department</option>
                                <option <?php if (in_array('alldept', $search)) echo 'selected'; ?> value="alldept">ALL</option>
                                <option <?php if (in_array('CSE', $search)) echo 'selected'; ?> value="CSE">CSE</option>
                                <option <?php if (in_array('EEE', $search)) echo 'selected'; ?> value="EEE">EEE</option>
                                <option <?php if (in_array('CE', $search)) echo 'selected'; ?> value="CE">CE</option>
                                <option <?php if (in_array('ICE', $search)) echo 'selected'; ?> value="ICE">ICE</option>
                                <option <?php if (in_array('BBA', $search)) echo 'selected'; ?> value="BBA">BBA</option>
                                <option <?php if (in_array('ENGLISH', $search)) echo 'selected'; ?> value="ENGLISH">ENGLISH</option>
                                <option <?php if (in_array('LAW', $search)) echo 'selected'; ?> value="LAW">LAW</option>
                            </select>
                        </div>

                    </form>
                    <form action="" method="post" style="float:right;display:flex;align-items:center;" id="setmeal">
                        @csrf
                        <input type="checkbox" style="margin-left:20px;height:20px;width:30px;" name="meal_no" value="zero"><span style="margin-right:40px;margin-left:4px;">Set all meal zero initially</span>
                        <input type="checkbox" style="margin-left:20px;height:20px;width:30px;" name="meal_no" value="one"><span style="margin-right:40px;margin-left:4px;">Set all meal one initially</span>
                    </form>
                </div>
