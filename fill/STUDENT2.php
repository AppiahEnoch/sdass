<div id="wrapper4" class="container justify-content-center align-items-center mt-2 d-none">
  <h4 class="text-center form-title">Student Details</h4> <!-- Descriptive Header -->
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
      <form id="student_detail_form2">
        <!-- Input for Date of Birth -->
        <div class="mb-3">
          <label for="dob" class="form-label">Date of Birth</label>
          <input required type="date" class="form-control" id="dob" placeholder="DATE OF BIRTH"
                 onchange="this.className=(this.value!=''?'has-value':'')">
        </div>

        <!-- Input for Place of Birth -->
        <div class="mb-3">
          <label for="placeOfbirth" class="form-label">Place of Birth</label>
          <input required type="text" class="form-control" id="placeOfbirth" placeholder="PLACE OF BIRTH">
        </div>

        <!-- Input for Home Town -->
        <div class="mb-3">
          <label for="hometown" class="form-label">Home Town</label>
          <input required type="text" class="form-control" id="hometown" placeholder="HOME TOWN">
        </div>

        <!-- Select for Religion -->
        <div class="mb-3">
          <label for="religion" class="form-label">Religion</label>
          <select class="form-select" id="religion">
            <option value="none">Choose religion</option>
            <option value="Christianity">Christianity</option>
            <option value="Islam">Islam</option>
            <option value="African Traditional">African Traditional</option>
          </select>
        </div>









        <!-- Input for Denomination -->
        <div class="mb-3">
          <label for="denomination" class="form-label">Denomination</label>
          <input required type="text" class="form-control" id="denomination" placeholder="DENOMINATION e.g SDA, Roman, Methodist etc">
       
    <select class="w-100" name="churches" id="churches">
    <option value="churchOfPentecost">The Church of Pentecost</option>
    <option value="catholicChurchGhana">Catholic Church of Ghana</option>
    <option value="presbyterianChurchGhana">Presbyterian Church Ghana</option>
    <option value="methodistChurchGhana">Methodist Church Ghana</option>
    <option value="perezChapelInternational">Perez Chapel International</option>
    <option value="redeemedChristianChurchOfGod">Redeemed Christian Church Of God</option>
    <option value="deeperChristianLifeMinistry">Deeper Christian Life Ministry</option>
    <option value="internationalCentralGospelChurch">International Central Gospel Church (ICGC)</option>
    <option value="lighthouseChapelInternational">Lighthouse Chapel International</option>
    <option value="actionChapelInternational">Action Chapel International</option>
    <option value="assembliesOfGodGhana">Assemblies of God Ghana</option>
    <option value="omegaFireMinistriesGhana">Omega Fire Ministries Ghana</option>
    <option value="victoryBibleChurchInternational">Victory Bible Church International</option>
    <option value="destinyAltarMinistries">Destiny Altar Ministries</option>
    <option value="charismaticEvangelisticMinistry">Charismatic Evangelistic Ministry</option>
    <option value="globalRevivalMinistries">Global Revival Ministries</option>
    <option value="eastwoodAnabaMinistries">Eastwood Anaba Ministries</option>
    <option value="royalHouseChapelInternational">Royal House Chapel International</option>
    <option value="livingFaithChurchGhana">Living Faith Church Ghana</option>
    <option value="christEmbassyGhana">Christ Embassy Ghana</option>
    <option value="seventhDayAdventistChurchGhana">Seventh Day Adventist Church, Ghana</option>
    <option value="jehovahsWitnesses">Jehovah's Witnesses</option>
    <option value="anglicanChurchGhana">Anglican Church of Ghana</option>
    <option value="baptistChurchGhana">Baptist Church of Ghana</option>
    <option value="evangelicalCharismaticChurch">Evangelical Charismatic Church</option>
    <option value="lutheranChurchGhana">Lutheran Church of Ghana</option>
    <option value="apostolicChurchGhana">The Apostolic Church  Ghana</option>
    <option value="christApostolicChurch">Christ Apostolic Church</option>
    <option value="quakersAfricaGhana">Quakers in Africa (Ghana)</option>
    <option value="unitedDenominationLighthouse">United Denomination: Lighthouse Group of Churches</option>
    <option value="christApostolicChurchInternational">Christ Apostolic Church International</option>

</select>
       
       

        </div>



        

        <!-- Buttons -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="row">
            <div class="col-7">
               <button type="submit" class="btn btn-primary w-100">Next</button>
            </div>
            <div class="col-5">
              <button id="student2_back" type="button"  class="btn btn-secondary w-100">Back</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
