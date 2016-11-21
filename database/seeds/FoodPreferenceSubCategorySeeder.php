<?php
use App\FoodPreferenceSubCategory;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use database\migrations\CreateUsersGoalTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;  

class FoodPreferenceSubCategorySeeder extends Seeder
{
    public function run()
    {
        $data = '{"1":{"name":"Vegetarian","parent_id":"1"},"2":{"name":"Pescetarian","parent_id":"1"},"3":{"name":"Vegan","parent_id":"1"},"4":{"name":"Gluten Free","parent_id":"1"},"5":{"name":"Lactose Free","parent_id":"1"},"6":{"name":"Milk","parent_id":"1"},"7":{"name":"Peanuts","parent_id":"1"},"8":{"name":"Tree nuts","parent_id":"1"},"9":{"name":"Soy","parent_id":"1"},"10":{"name":"Wheat","parent_id":"1"},"11":{"name":"Fish","parent_id":"1"},"12":{"name":"Shellfish","parent_id":"1"},"13":{"name":"Bacon","parent_id":"2"},"14":{"name":"Beef","parent_id":"2"},"15":{"name":"Chicken","parent_id":"2"},"16":{"name":"Egg","parent_id":"2"},"17":{"name":"Fish - white","parent_id":"2"},"18":{"name":"Fish - salmon","parent_id":"2"},"19":{"name":"Ham","parent_id":"2"},"20":{"name":"Kangaroo","parent_id":"2"},"21":{"name":"Lamb","parent_id":"2"},"22":{"name":"Legumes","parent_id":"2"},"23":{"name":"Pork","parent_id":"2"},"24":{"name":"Prawns","parent_id":"2"},"25":{"name":"Tofu","parent_id":"2"},"26":{"name":"Tuna","parent_id":"2"},"27":{"name":"Turkey","parent_id":"2"},"28":{"name":"Bread","parent_id":"3"},"29":{"name":"Cereal","parent_id":"3"},"30":{"name":"Corn thins","parent_id":"3"},"31":{"name":"Crackers","parent_id":"3"},"32":{"name":"English muffins","parent_id":"3"},"33":{"name":"Fries\/wedges","parent_id":"3"},"34":{"name":"Muesli","parent_id":"3"},"35":{"name":"oatmeal","parent_id":"3"},"36":{"name":"Pasta","parent_id":"3"},"37":{"name":"Raisin Toast","parent_id":"3"},"38":{"name":"Rice","parent_id":"3"},"39":{"name":"Rice cakes","parent_id":"3"},"40":{"name":"Wraps","parent_id":"3"},"41":{"name":"Crumpets","parent_id":"3"},"42":{"name":"Granola","parent_id":"3"},"43":{"name":"Pizza Base","parent_id":"3"},"44":{"name":"Taco Shells","parent_id":"3"},"45":{"name":"noodles","parent_id":"3"},"46":{"name":"Apple","parent_id":"4"},"47":{"name":"Avocado","parent_id":"4"},"48":{"name":"Banana","parent_id":"4"},"49":{"name":"Beans","parent_id":"4"},"50":{"name":"Beetroot","parent_id":"4"},"51":{"name":"Berries","parent_id":"4"},"52":{"name":"Broccoli","parent_id":"4"},"53":{"name":"Capsicum","parent_id":"4"},"54":{"name":"Carrot","parent_id":"4"},"55":{"name":"Corn","parent_id":"4"},"56":{"name":"Cucumber","parent_id":"4"},"57":{"name":"Grapes","parent_id":"4"},"58":{"name":"Lettuce","parent_id":"4"},"59":{"name":"Mandarin","parent_id":"4"},"60":{"name":"Mushroom","parent_id":"4"},"61":{"name":"Nectarine","parent_id":"4"},"62":{"name":"Onion","parent_id":"4"},"63":{"name":"Orange","parent_id":"4"},"64":{"name":"Peach","parent_id":"4"},"65":{"name":"Peas","parent_id":"4"},"66":{"name":"Pumpkin","parent_id":"4"},"67":{"name":"Spinach","parent_id":"4"},"68":{"name":"Sweet Potato","parent_id":"4"},"69":{"name":"Tomato","parent_id":"4"},"70":{"name":"Watermelon","parent_id":"4"},"71":{"name":"White Potato","parent_id":"4"},"72":{"name":"Zucchini","parent_id":"4"},"73":{"name":"Mixed Lettuce","parent_id":"4"},"74":{"name":"Olives","parent_id":"4"},"75":{"name":"Pineapple","parent_id":"4"},"76":{"name":"Celery","parent_id":"4"},"77":{"name":"Cheese","parent_id":"5"},"78":{"name":"Cottage cheese","parent_id":"5"},"79":{"name":"Cream cheese","parent_id":"5"},"80":{"name":"Feta cheese","parent_id":"5"},"81":{"name":"Flavoured yogurt","parent_id":"5"},"82":{"name":"Milk - almond (alternative)","parent_id":"5"},"83":{"name":"Milk - full cream","parent_id":"5"},"84":{"name":"Milk - skim","parent_id":"5"},"85":{"name":"Milk - soy (alternative)","parent_id":"5"},"86":{"name":"Greek yogurt","parent_id":"5"},"87":{"name":"Ricotta cheese","parent_id":"5"},"88":{"name":"Sour cream","parent_id":"5"},"89":{"name":"Cream","parent_id":"5"},"90":{"name":"Cake","parent_id":"6"},"91":{"name":"Candy","parent_id":"6"},"92":{"name":"Biscuits","parent_id":"6"},"93":{"name":"Ice-cream","parent_id":"6"},"94":{"name":"Muesli Bars","parent_id":"6"},"95":{"name":"Nuts","parent_id":"6"},"96":{"name":"Pastry","parent_id":"6"},"97":{"name":"Potato chips","parent_id":"6"},"98":{"name":"Dips","parent_id":"6"},"99":{"name":"Chocolate - Milk","parent_id":"6"},"100":{"name":"Chocolate - Dark","parent_id":"6"},"101":{"name":"Sorbet","parent_id":"6"},"102":{"name":"Nut Bars","parent_id":"6"},"103":{"name":"Puddings & Custard","parent_id":"6"},"104":{"name":"Butter","parent_id":"7"},"105":{"name":"Honey","parent_id":"7"},"106":{"name":"Jam","parent_id":"7"},"107":{"name":"Marinade","parent_id":"7"},"108":{"name":"Mayonnaise","parent_id":"7"},"109":{"name":"Nutella","parent_id":"7"},"110":{"name":"Nut Butters","parent_id":"7"},"111":{"name":"Sauce","parent_id":"7"},"112":{"name":"Soy Sauce","parent_id":"7"},"113":{"name":"Vegemite","parent_id":"7"},"114":{"name":"Maple Syrup","parent_id":"7"},"115":{"name":"Salad Dressing","parent_id":"7"},"116":{"name":"Maple Syrup","parent_id":"7"},"117":{"name":"Salad Dressing","parent_id":"7"},"118":{"name":"Up and Go","parent_id":"8"},"119":{"name":"Protein Shakes","parent_id":"8"},"120":{"name":"Hot Chocolate","parent_id":"8"},"121":{"name":"Protein powder","parent_id":"9"},"122":{"name":"Quest bars","parent_id":"9"},"123":{"name":"Other protein bars","parent_id":"9"},"124":{"name":"Lenny & Larry \'s Cookie","parent_id":"9"}}';
        $data = json_decode($data, true);       
        DB::table('food_preference_subcategory')->insert($data);
    }
} 