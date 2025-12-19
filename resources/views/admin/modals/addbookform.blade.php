@extends('layouts.adminapp')
@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12 mt-4">
                <div class="card bg-dark card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-book pr-3"></i>Form Daftar Buku</h3>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 mt-2">
            <div class="card bg-dark card-primary card-outline">
            <form action="{{ route('saveBuku') }}" method="post" id="form" enctype="multipart/form-data">
                @csrf
                <div class="card-body bg-dark">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Tambah judul...">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Tambah penulis...">
                  </div>
                  <div class="form-group">
                    <label for="examplePenerbit">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Tambah Penerbit...">
                  </div>
                  <div class="form-group">
                    <label for="exampleNegaraPerilisan">Negara Penerbitan</label>
                    <select class="custom-select rounded-50 select2bs4" id="negara" name="negara">  
                      <option value="AF">Afghanistan</option>
                      <option value="AX">Åland Islands</option>
                      <option value="AL">Albania</option>
                      <option value="DZ">Algeria</option>
                      <option value="AS">American Samoa</option>
                      <option value="AD">Andorra</option>
                      <option value="AO">Angola</option>
                      <option value="AI">Anguilla</option>
                      <option value="AQ">Antarctica</option>
                      <option value="AG">Antigua and Barbuda</option>
                      <option value="AR">Argentina</option>
                      <option value="AM">Armenia</option>
                      <option value="AW">Aruba</option>
                      <option value="AU">Australia</option>
                      <option value="AT">Austria</option>
                      <option value="AZ">Azerbaijan</option>
                      <option value="BS">Bahamas</option>
                      <option value="BH">Bahrain</option>
                      <option value="BD">Bangladesh</option>
                      <option value="BB">Barbados</option>
                      <option value="BY">Belarus</option>
                      <option value="BE">Belgium</option>
                      <option value="BZ">Belize</option>
                      <option value="BJ">Benin</option>
                      <option value="BM">Bermuda</option>
                      <option value="BT">Bhutan</option>
                      <option value="BO">Bolivia, Plurinational State of</option>
                      <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                      <option value="BA">Bosnia and Herzegovina</option>
                      <option value="BW">Botswana</option>
                      <option value="BV">Bouvet Island</option>
                      <option value="BR">Brazil</option>
                      <option value="IO">British Indian Ocean Territory</option>
                      <option value="BN">Brunei Darussalam</option>
                      <option value="BG">Bulgaria</option>
                      <option value="BF">Burkina Faso</option>
                      <option value="BI">Burundi</option>
                      <option value="KH">Cambodia</option>
                      <option value="CM">Cameroon</option>
                      <option value="CA">Canada</option>
                      <option value="CV">Cape Verde</option>
                      <option value="KY">Cayman Islands</option>
                      <option value="CF">Central African Republic</option>
                      <option value="TD">Chad</option>
                      <option value="CL">Chile</option>
                      <option value="CN">China</option>
                      <option value="CX">Christmas Island</option>
                      <option value="CC">Cocos (Keeling) Islands</option>
                      <option value="CO">Colombia</option>
                      <option value="KM">Comoros</option>
                      <option value="CG">Congo</option>
                      <option value="CD">Congo, the Democratic Republic of the</option>
                      <option value="CK">Cook Islands</option>
                      <option value="CR">Costa Rica</option>
                      <option value="CI">Côte d'Ivoire</option>
                      <option value="HR">Croatia</option>
                      <option value="CU">Cuba</option>
                      <option value="CW">Curaçao</option>
                      <option value="CY">Cyprus</option>
                      <option value="CZ">Czech Republic</option>
                      <option value="DK">Denmark</option>
                      <option value="DJ">Djibouti</option>
                      <option value="DM">Dominica</option>
                      <option value="DO">Dominican Republic</option>
                      <option value="EC">Ecuador</option>
                      <option value="EG">Egypt</option>
                      <option value="SV">El Salvador</option>
                      <option value="GQ">Equatorial Guinea</option>
                      <option value="ER">Eritrea</option>
                      <option value="EE">Estonia</option>
                      <option value="ET">Ethiopia</option>
                      <option value="FK">Falkland Islands (Malvinas)</option>
                      <option value="FO">Faroe Islands</option>
                      <option value="FJ">Fiji</option>
                      <option value="FI">Finland</option>
                      <option value="FR">France</option>
                      <option value="GF">French Guiana</option>
                      <option value="PF">French Polynesia</option>
                      <option value="TF">French Southern Territories</option>
                      <option value="GA">Gabon</option>
                      <option value="GM">Gambia</option>
                      <option value="GE">Georgia</option>
                      <option value="DE">Germany</option>
                      <option value="GH">Ghana</option>
                      <option value="GI">Gibraltar</option>
                      <option value="GR">Greece</option>
                      <option value="GL">Greenland</option>
                      <option value="GD">Grenada</option>
                      <option value="GP">Guadeloupe</option>
                      <option value="GU">Guam</option>
                      <option value="GT">Guatemala</option>
                      <option value="GG">Guernsey</option>
                      <option value="GN">Guinea</option>
                      <option value="GW">Guinea-Bissau</option>
                      <option value="GY">Guyana</option>
                      <option value="HT">Haiti</option>
                      <option value="HM">Heard Island and McDonald Islands</option>
                      <option value="VA">Holy See (Vatican City State)</option>
                      <option value="HN">Honduras</option>
                      <option value="HK">Hong Kong</option>
                      <option value="HU">Hungary</option>
                      <option value="IS">Iceland</option>
                      <option value="IN">India</option>
                      <option value="ID">Indonesia</option>
                      <option value="IR">Iran, Islamic Republic of</option>
                      <option value="IQ">Iraq</option>
                      <option value="IE">Ireland</option>
                      <option value="IM">Isle of Man</option>
                      <option value="IL">Israel</option>
                      <option value="IT">Italy</option>
                      <option value="JM">Jamaica</option>
                      <option value="JP">Japan</option>
                      <option value="JE">Jersey</option>
                      <option value="JO">Jordan</option>
                      <option value="KZ">Kazakhstan</option>
                      <option value="KE">Kenya</option>
                      <option value="KI">Kiribati</option>
                      <option value="KP">Korea, Democratic People's Republic of</option>
                      <option value="KR">Korea, Republic of</option>
                      <option value="KW">Kuwait</option>
                      <option value="KG">Kyrgyzstan</option>
                      <option value="LA">Lao People's Democratic Republic</option>
                      <option value="LV">Latvia</option>
                      <option value="LB">Lebanon</option>
                      <option value="LS">Lesotho</option>
                      <option value="LR">Liberia</option>
                      <option value="LY">Libya</option>
                      <option value="LI">Liechtenstein</option>
                      <option value="LT">Lithuania</option>
                      <option value="LU">Luxembourg</option>
                      <option value="MO">Macao</option>
                      <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                      <option value="MG">Madagascar</option>
                      <option value="MW">Malawi</option>
                      <option value="MY">Malaysia</option>
                      <option value="MV">Maldives</option>
                      <option value="ML">Mali</option>
                      <option value="MT">Malta</option>
                      <option value="MH">Marshall Islands</option>
                      <option value="MQ">Martinique</option>
                      <option value="MR">Mauritania</option>
                      <option value="MU">Mauritius</option>
                      <option value="YT">Mayotte</option>
                      <option value="MX">Mexico</option>
                      <option value="FM">Micronesia, Federated States of</option>
                      <option value="MD">Moldova, Republic of</option>
                      <option value="MC">Monaco</option>
                      <option value="MN">Mongolia</option>
                      <option value="ME">Montenegro</option>
                      <option value="MS">Montserrat</option>
                      <option value="MA">Morocco</option>
                      <option value="MZ">Mozambique</option>
                      <option value="MM">Myanmar</option>
                      <option value="NA">Namibia</option>
                      <option value="NR">Nauru</option>
                      <option value="NP">Nepal</option>
                      <option value="NL">Netherlands</option>
                      <option value="NC">New Caledonia</option>
                      <option value="NZ">New Zealand</option>
                      <option value="NI">Nicaragua</option>
                      <option value="NE">Niger</option>
                      <option value="NG">Nigeria</option>
                      <option value="NU">Niue</option>
                      <option value="NF">Norfolk Island</option>
                      <option value="MP">Northern Mariana Islands</option>
                      <option value="NO">Norway</option>
                      <option value="OM">Oman</option>
                      <option value="PK">Pakistan</option>
                      <option value="PW">Palau</option>
                      <option value="PS">Palestinian Territory, Occupied</option>
                      <option value="PA">Panama</option>
                      <option value="PG">Papua New Guinea</option>
                      <option value="PY">Paraguay</option>
                      <option value="PE">Peru</option>
                      <option value="PH">Philippines</option>
                      <option value="PN">Pitcairn</option>
                      <option value="PL">Poland</option>
                      <option value="PT">Portugal</option>
                      <option value="PR">Puerto Rico</option>
                      <option value="QA">Qatar</option>
                      <option value="RE">Réunion</option>
                      <option value="RO">Romania</option>
                      <option value="RU">Russian Federation</option>
                      <option value="RW">Rwanda</option>
                      <option value="BL">Saint Barthélemy</option>
                      <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                      <option value="KN">Saint Kitts and Nevis</option>
                      <option value="LC">Saint Lucia</option>
                      <option value="MF">Saint Martin (French part)</option>
                      <option value="PM">Saint Pierre and Miquelon</option>
                      <option value="VC">Saint Vincent and the Grenadines</option>
                      <option value="WS">Samoa</option>
                      <option value="SM">San Marino</option>
                      <option value="ST">Sao Tome and Principe</option>
                      <option value="SA">Saudi Arabia</option>
                      <option value="SN">Senegal</option>
                      <option value="RS">Serbia</option>
                      <option value="SC">Seychelles</option>
                      <option value="SL">Sierra Leone</option>
                      <option value="SG">Singapore</option>
                      <option value="SX">Sint Maarten (Dutch part)</option>
                      <option value="SK">Slovakia</option>
                      <option value="SI">Slovenia</option>
                      <option value="SB">Solomon Islands</option>
                      <option value="SO">Somalia</option>
                      <option value="ZA">South Africa</option>
                      <option value="GS">South Georgia and the South Sandwich Islands</option>
                      <option value="SS">South Sudan</option>
                      <option value="ES">Spain</option>
                      <option value="LK">Sri Lanka</option>
                      <option value="SD">Sudan</option>
                      <option value="SR">Suriname</option>
                      <option value="SJ">Svalbard and Jan Mayen</option>
                      <option value="SZ">Swaziland</option>
                      <option value="SE">Sweden</option>
                      <option value="CH">Switzerland</option>
                      <option value="SY">Syrian Arab Republic</option>
                      <option value="TW">Taiwan, Province of China</option>
                      <option value="TJ">Tajikistan</option>
                      <option value="TZ">Tanzania, United Republic of</option>
                      <option value="TH">Thailand</option>
                      <option value="TL">Timor-Leste</option>
                      <option value="TG">Togo</option>
                      <option value="TK">Tokelau</option>
                      <option value="TO">Tonga</option>
                      <option value="TT">Trinidad and Tobago</option>
                      <option value="TN">Tunisia</option>
                      <option value="TR">Turkey</option>
                      <option value="TM">Turkmenistan</option>
                      <option value="TC">Turks and Caicos Islands</option>
                      <option value="TV">Tuvalu</option>
                      <option value="UG">Uganda</option>
                      <option value="UA">Ukraine</option>
                      <option value="AE">United Arab Emirates</option>
                      <option value="GB">United Kingdom</option>
                      <option value="US">United States</option>
                      <option value="UM">United States Minor Outlying Islands</option>
                      <option value="UY">Uruguay</option>
                      <option value="UZ">Uzbekistan</option>
                      <option value="VU">Vanuatu</option>
                      <option value="VE">Venezuela, Bolivarian Republic of</option>
                      <option value="VN">Viet Nam</option>
                      <option value="VG">Virgin Islands, British</option>
                      <option value="VI">Virgin Islands, U.S.</option>
                      <option value="WF">Wallis and Futuna</option>
                      <option value="EH">Western Sahara</option>
                      <option value="YE">Yemen</option>
                      <option value="ZM">Zambia</option>
                      <option value="ZW">Zimbabwe</option>
                      </select>
                  </div> 
                  <div class="form-group">
                      <label>Deskripsi Buku</label>
                      <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Tambah Deskripsi..."></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleSelectRounded0">Jenis Buku</label>
                    <select class="custom-select rounded-50" id="jenis" name="jenis">
                      <option value="Buku-Paket">Buku-Paket</option>
                      <option value="Ensiklopdia">Ensiklopedia</option>
                      <option value="Komik">Komik</option>
                      <option value="Majalah">Majalah</option>
                      <option value="Novel">Novel</option>
                      <option value="Referensi">Referensi</option>
                      <option value="Lainnya">Lainnya</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleSelectRounded0">Genre Buku</label>
                    <select class="custom-select rounded-50" id="genre" name="genre">
                      <option value="Agama">Agama</option>
                      <option value="Anak & Remaja">Anak & Remaja</option>
                      <option value="Biografi">Biografi</option>
                      <option value="Bisnis & Ekonomi">Bisnis & Ekonomi</option>
                      <option value="Cerpen">Cerpen</option>
                      <option value="Fantasi">Fantasi</option>
                      <option value="Fiksi">Fiksi</option>
                      <option value="Hobi & Keterampilan">Hobi & Keterampilan</option>
                      <option value="Horror">Horror</option>
                      <option value="Komedi">Komedi</option>
                      <option value="Komputer & IT">Komputer & IT</option>
                      <option value="Misteri & Thriller">Misteri & Thriller</option>
                      <option value="Nonfiksi">Nonfiksi</option>
                      <option value="Pendidikan">Pendidikan</option>
                      <option value="Petualangan">Petualangan</option>
                      <option value="Psikologi">Psikologi</option>
                      <option value="Puisi">Puisi</option>
                      <option value="Sains">Sains</option>
                      <option value="Sains Populer">Sains Populer</option>
                      <option value="Sejarah">Sejarah</option>
                      <option value="Slice of Life">Slice of Life</option>
                      <option value="Sosial & Budaya">Sosial & Budaya</option>
                      <option value="Teknologi">Teknologi</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Deskripsi Fisik</label>
                    <input type="text" class="form-control mb-2" id="volume" name="volume" placeholder="Volume buku...">
                    <input type="text" class="form-control mb-2" id="halaman" name="halaman" placeholder="Jumlah halaman...">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Bahasa</label>
                    <select class="custom-select rounded-50 select2bs4" id="bahasa" name="bahasa">  
                      <option value=af>Afrikaans</option>
                      <option value=sq>Albanian</option>
                      <option value=am>Amharic</option>
                      <option value=ar>Arabic</option>
                      <option value=hy>Armenian</option>
                      <option value=az>Azerbaijani</option>
                      <option value=eu>Basque</option>
                      <option value=be>Belarusian</option>
                      <option value=bn>Bengali</option>
                      <option value=bs>Bosnian</option>
                      <option value=bg>Bulgarian</option>
                      <option value=ca>Catalan</option>
                      <option value=ceb>Cebuano</option>
                      <option value=ny>Chichewa</option>
                      <option value=zh-CN>Chinese</option>
                      <option value=co>Corsican</option>
                      <option value=hr>Croatian</option>
                      <option value=cs>Czech</option>
                      <option value=da>Danish</option>
                      <option value=nl>Dutch</option>
                      <option value=en>English</option>
                      <option value=eo>Esperanto</option>
                      <option value=et>Estonian</option>
                      <option value=tl>Filipino</option>
                      <option value=fi>Finnish</option>
                      <option value=fr>French</option>
                      <option value=fy>Frisian</option>
                      <option value=gl>Galician</option>
                      <option value=ka>Georgian</option>
                      <option value=de>German</option>
                      <option value=el>Greek</option>
                      <option value=gu>Gujarati</option>
                      <option value=ht>Haitian Creole</option>
                      <option value=ha>Hausa</option>
                      <option value=haw>Hawaiian</option>
                      <option value=iw>Hebrew</option>
                      <option value=hi>Hindi</option>
                      <option value=hmn>Hmong</option>
                      <option value=hu>Hungarian</option>
                      <option value=is>Icelandic</option>
                      <option value=ig>Igbo</option>
                      <option value=id>Indonesian</option>
                      <option value=ga>Irish</option>
                      <option value=it>Italian</option>
                      <option value=ja>Japanese</option>
                      <option value=jw>Javanese</option>
                      <option value=kn>Kannada</option>
                      <option value=kk>Kazakh</option>
                      <option value=km>Khmer</option>
                      <option value=ko>Korean</option>
                      <option value=ku>Kurdish (Kurmanji)</option>
                      <option value=ky>Kyrgyz</option>
                      <option value=lo>Lao</option>
                      <option value=la>Latin</option>
                      <option value=lv>Latvian</option>
                      <option value=lt>Lithuanian</option>
                      <option value=lb>Luxembourgish</option>
                      <option value=mk>Macedonian</option>
                      <option value=mg>Malagasy</option>
                      <option value=ms>Malay</option>
                      <option value=ml>Malayalam</option>
                      <option value=mt>Maltese</option>
                      <option value=mi>Maori</option>
                      <option value=mr>Marathi</option>
                      <option value=mn>Mongolian</option>
                      <option value=my>Myanmar (Burmese)</option>
                      <option value=ne>Nepali</option>
                      <option value=no>Norwegian</option>
                      <option value=ps>Pashto</option>
                      <option value=fa>Persian</option>
                      <option value=pl>Polish</option>
                      <option value=pt>Portuguese</option>
                      <option value=pa>Punjabi</option>
                      <option value=ro>Romanian</option>
                      <option value=ru>Russian</option>
                      <option value=sm>Samoan</option>
                      <option value=gd>Scots Gaelic</option>
                      <option value=sr>Serbian</option>
                      <option value=st>Sesotho</option>
                      <option value=sn>Shona</option>
                      <option value=sd>Sindhi</option>
                      <option value=si>Sinhala</option>
                      <option value=sk>Slovak</option>
                      <option value=sl>Slovenian</option>
                      <option value=so>Somali</option>
                      <option value=es>Spanish</option>
                      <option value=su>Sundanese</option>
                      <option value=sw>Swahili</option>
                      <option value=sv>Swedish</option>
                      <option value=tg>Tajik</option>
                      <option value=ta>Tamil</option>
                      <option value=te>Telugu</option>
                      <option value=th>Thai</option>
                      <option value=tr>Turkish</option>
                      <option value=uk>Ukrainian</option>
                      <option value=ur>Urdu</option>
                      <option value=uz>Uzbek</option>
                      <option value=vi>Vietnamese</option>
                      <option value=cy>Welsh</option>
                      <option value=xh>Xhosa</option>
                      <option value=yi>Yiddish</option>
                      <option value=yo>Yoruba</option>
                      <option value=zu>Zulu</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">ISBN/ISSN</label>
                    <input type="text" class="form-control" id="issn" name="issn" placeholder="000-0-0-000000-0">
                  </div>
                  <div class="form-group">
                    <label for="exampleDatePicker">Tahun Terbit</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tahun_terbit" id="tahun_terbit"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Sampul Buku</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="form-control" id="cover" name="cover">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex mb-2">
                  <a href="{{ url()->previous() }}">
                    <button type="button" class="btn btn-danger">Close</button>
                  </a>
                  <button type="submit" class="btn btn-primary ml-auto">Save changes</button>
                </div>
            </form>
            </div>
              </div>
            </div>
        </div>
</section>
<!-- bs-custom-file-input -->
<script src="{{asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  $(function (){
    $('#reservationdate').datetimepicker({
      format: 'YYYY',
      viewMode: 'years'
    });
  });
</script> 
@endsection