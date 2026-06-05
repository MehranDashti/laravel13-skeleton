<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute باید پذیرفته شده باشد.',
    'active_url' => 'آدرس :attribute معتبر نیست',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'alpha' => ':attribute باید شامل حروف الفبا باشد.',
    'alpha_dash' => ':attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.',
    'alpha_num' => ':attribute باید شامل حروف الفبا و عدد باشد.',
    'array' => ':attribute باید شامل آرایه باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'between' => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean' => 'فیلد :attribute فقط میتواند صحیح و یا غلط باشد',
    'confirmed' => ':attribute با تاییدیه مطابقت ندارد.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_format' => ':attribute با الگوی :format مطاقبت ندارد.',
    'different' => ':attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'email' => 'فرمت :attribute معتبر نیست.',
    'exists' => ':attribute انتخاب شده، معتبر نیست.',
    'filled' => 'فیلد :attribute الزامی است',
    'image' => ':attribute باید تصویر باشد.',
    'in' => ':attribute انتخاب شده، معتبر نیست.',
    'integer' => ':attribute باید نوع داده ای عددی (عدد) باشد.',
    'ip' => ':attribute باید IP آدرس معتبر باشد.',
    'max' => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array' => ':attribute نباید بیشتر از :max آیتم باشد.',
    ],
    'mimes' => ':attribute باید یکی از فرمت های :values باشد.',
    'min' => [
        'numeric' => ':attribute نباید کوچکتر از :min باشد.',
        'file' => ':attribute نباید کوچکتر از :min کیلوبایت باشد.',
        'string' => ':attribute نباید کمتر از :min کاراکتر باشد.',
        'array' => ':attribute نباید کمتر از :min آیتم باشد.',
    ],
    'not_in' => ':attribute انتخاب شده، معتبر نیست.',
    'numeric' => ':attribute باید شامل عدد باشد.',
    'regex' => ':attribute یک فرمت معتبر نیست',
    'required' => 'فیلد :attribute الزامی است',
    'required_if' => 'فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.',
    'required_with' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_with_all' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_without' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'required_without_all' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'same' => ':attribute و :other باید مانند هم باشند.',
    'size' => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'file' => ':attribute باید برابر با :size کیلوبایت باشد.',
        'string' => ':attribute باید برابر با :size کاراکتر باشد.',
        'array' => ':attribute باسد شامل :size آیتم باشد.',
    ],
    'string' => ':attribute باید رشته باشد.',
    'timezone' => 'فیلد :attribute باید یک منطقه صحیح باشد.',
    'unique' => ':attribute قبلا انتخاب شده است.',
    'url' => 'فرمت آدرس :attribute اشتباه است.',
    'uuid' => ':attribute باید شناسه معتبر UUID باشد.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'file' => 'The :attribute must be a file.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'in_array' => 'The :attribute field does not exist in :other.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'multiple_of' => 'The :attribute must be a multiple of :value',
    'not_regex' => 'The :attribute format is invalid.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'uploaded' => 'The :attribute failed to upload.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'نام',
        'username' => 'نام کاربری',
        'email' => 'پست الکترونیکی',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'family' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تاییدیه ی رمز عبور',
        'city' => 'شهر',
        'country' => 'کشور',
        'address' => 'نشانی',
        'phone' => 'تلفن',
        'mobile' => 'تلفن همراه',
        'age' => 'سن',
        'sex' => 'جنسیت',
        'gender' => 'جنسیت',
        'day' => 'روز',
        'month' => 'ماه',
        'year' => 'سال',
        'hour' => 'ساعت',
        'minute' => 'دقیقه',
        'second' => 'ثانیه',
        'title' => 'عنوان',
        'text' => 'متن',
        'content' => 'محتوا',
        'content_category_id' => 'دسته بندی محتوا',
        'description' => 'توضیحات',
        'excerpt' => 'گلچین کردن',
        'date' => 'تاریخ',
        'time' => 'زمان',
        'available' => 'موجود',
        'size' => 'اندازه',
        'file' => 'فایل',
        'full_name' => 'نام کامل',
        'role_name' => 'نام نقش',
        'role_title' => 'عنوان نقش',
        'role_permissions' => 'دسترسی های نقش',
        'service_name' => 'نام سرویس',
        'permissions' => 'دسترسی',
        'permissions.*' => 'دسترسی ها',
        'permissions.*.alias' => 'نام دسترسی',
        'permissions.*.title' => 'عنوان دسترسی',
        'status' => 'وضعیت',
        'count' => 'تعداد',
        'type' => 'نوع',
        'user_ids' => 'شناسه کاربران',
        'priorities' => 'اولویت',
        'priorities.*.id' => 'شناسه های',
        'priorities.*.priority' => 'اولویت های',
        'message' => 'پیام',
        'users' => 'لیست کاربران',
        'users.*' => 'کاربر',
        'priority' => 'کد',
        'image' => 'تصویر',
        'alt_image' => 'متن تصویر',
        'parent_id' => 'شناسه‌ی والد',
        'banner_image' => ' تصویر بنر',
        'alt_banner_image' => 'متن تصویر بنر',
        'product_ids' => 'شناسه‌ی محصولات',
        'color' => 'رنگ',
        'user_code' => 'کد کاربر',
        'expire_at' => 'تاریخ انقضا',
        'order_code' => 'کد سفارش',
        'percentage' => 'درصد',
        'condition' => 'شرط',
        'condition_data' => 'داده‌های شرط',
        'preview_image' => 'یش نمایش تصویر',
        'alt_preview_image' => 'متن یش نمایش تصویر',
        'start_at' => 'تاریخ شروع',
        'end_at' => 'تاریخ پایان',
        'details' => 'جزییات',
        'product_group_id' => 'شناسه گروه محصول',
        'product_group_codes' => 'کد گروه محصول',
        'product_group_codes.*' => 'کد گروه محصول',
        'can_decrease_cv' => 'کاهش cv',
        'maximum_use_count' => 'حداکثر استفاده',
        'gift_count' => 'تعداد هدیه',
        'how_to_use' => 'نحوه مصرف',
        'meta_title' => 'عنوان متا',
        'meta_description' => 'توضیحات متا',
        'product_family_id' => 'شناسه خانواده محصول',
        'category_id' => 'شناسه دسته‌بندی',
        'financial_number' => 'شماره مالی',
        'national_code' => 'کد ملی',
        'nationality_code' => 'کد ملی',
        'nature' => 'طبیعت',
        'has_sku' => 'sku',
        'batch_number' => 'شماره دسته',
        'abbreviation' => 'مخفف',
        'features' => 'امکانات',
        'attributes' => 'ویژگی ها',
        'product_id' => 'شناسه محصول',
        'price' => 'قیمت',
        'production_price' => 'تولید قیمت',
        'calculation_type' => 'نوع محاسبه',
        'profit_percent' => 'درصد سود',
        'weight' => 'وزن',
        'volume' => 'حجم',
        'has_tax' => 'مالیات',
        'expire_month' => 'تاریخ انقضا',
    ],
];
