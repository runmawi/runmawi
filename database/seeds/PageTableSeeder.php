<?php

use Illuminate\Database\Seeder;
use App\Page;
use Carbon\Carbon;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Page::truncate();

        $promotion_data ="What is Lorem Ipsum?
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        
        Why do we use it?
        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
        
        
        Where does it come from?
        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of 'de Finibus Bonorum et Malorum' (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 'Lorem ipsum dolor sit amet..', comes from a line in section 1.10.32.
        
        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
        
        Where can I get some?
        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc." ;



        $Page = [
                [  'user_id' => '1', 
                   'title' => 'Terms and Conditions',
                    'slug' => 'terms-and-conditions',
                    'body' => '<p>Terms and Conditions</p>' ,
                    'active' => '1', 
                    'banner' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [  'user_id' => '1', 
                   'title' => 'About Us',
                   'slug' => 'about-us',
                   'body' => '<p>About Us</p>' ,
                   'banner' => null,
                   'active' => '1',  
                   'created_at' => Carbon::now(),
                   'updated_at' => null,
                ],
                 [  'user_id' => '1', 
                    'title' => 'Copyright info',
                    'slug' => 'copyright-info',
                    'body' => '<p>Copyright info content</p>' ,
                    'banner' => null,
                    'active' => '0',  
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [  'user_id' => '1', 
                    'title' => 'Promotion',
                    'slug' => 'promotion',
                    'body' => $promotion_data ,
                    'body' => '<p>Copyright info content</p>' ,
                    'active' => '1', 
                    'banner' => 'elite-logo1.png',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [  
                    'user_id' => '1', 
                    'title' => 'Privacy Policy',
                    'slug' => 'privacy-policy',
                    'body' => '<p>Privacy Policy</p>' ,
                    'active' => '1',
                    'banner' => '6.png',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                 ],
        ];

        Page::insert($Page);
    }
}
