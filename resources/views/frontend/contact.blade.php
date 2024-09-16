@extends('frontend.layout.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{asset('assets/frontend/img/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Liên hệ</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Trang chủ</a>
                            <span>/Liên hệ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Số điện thoại</h4>
                        <p>0123456789</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Địa chỉ</h4>
                        <p>12 P. Chùa Bộc, Quang Trung, Đống Đa, Hà Nội 100000</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Thời gian mở cửa</h4>
                        <p>08:00 Sáng to 22:00 Tối</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Địa chỉ Email</h4>
                        <p>Biolife@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <div class="page-contain contact-us">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="wrap-map biolife-wrap-map" id="map-block">
                <iframe
                        width="1920"
                        height="591"
                        src="https://maps.google.com/maps?width=100%&amp;height=263&amp;hl=en&amp;q=1%20Grafton%20Street%2C%20Dublin%2C%20Ireland+(My%20Business%20Name)&amp;ie=UTF8&amp;t=p&amp;z=15&amp;iwloc=B&amp;output=embed"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0">
                </iframe>
            </div>

            <div class="container">

                <div class="row">

                    <!--Contact info-->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="contact-info-container sm-margin-top-27px xs-margin-bottom-60px xs-margin-top-60px">
                            <h4 class="box-title">Liên Hệ Với Chúng Tôi</h4>
                            <p class="frst-desc"></p>
                            <ul class="addr-info">
                                <li>
                                    <div class="if-item">
                                        <b class="tie">Địa Chỉ:</b>
                                        <p class="dsc">12 P. Chùa Bộc, Quang Trung, Đống Đa, Hà Nội 100000</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="if-item">
                                        <b class="tie">Số Điện Thoại:</b>
                                        <p class="dsc">0123456789</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="if-item">
                                        <b class="tie">Email:</b>
                                        <p class="dsc">Biolife@gmail.com</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="if-item">
                                        <b class="tie">Giờ Mở Cửa:</b>
                                        <p class="dsc">8Sáng - 08Tối, T2 - T7</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="biolife-social inline">
                                <ul class="socials">
                                    <li><a href="#" title="twitter" class="socail-btn"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#" title="facebook" class="socail-btn"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#" title="pinterest" class="socail-btn"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                    <li><a href="#" title="youtube" class="socail-btn"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                    <li><a href="#" title="instagram" class="socail-btn"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Contact form-->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="contact-form-container sm-margin-top-112px">
                            <form action="#" name="frm-contact" >
                                <p class="form-row">
                                    <input type="text" name="name" value="" placeholder="Your Name" class="txt-input">
                                </p>
                                <p class="form-row">
                                    <input type="email" name="email" value="" placeholder="Email Address" class="txt-input">
                                </p>
                                <p class="form-row">
                                    <input type="tel" name="phone" value="" placeholder="Phone Number" class="txt-input">
                                </p>
                                <p class="form-row">
                                    <textarea name="mes" id="mes-1" cols="30" rows="9" placeholder="Leave Message"></textarea>
                                </p>
                                <p class="form-row">
                                    <button class="btn btn-submit" type="submit">Gửi</button>
                                </p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Contact Form End -->
@endsection