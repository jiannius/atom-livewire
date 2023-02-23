<?php

namespace Jiannius\Atom\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallCommand extends Command
{
    protected $signature = 'atom:install
                            {modules? : Modules to be installed. Separate multiple modules with comma.}
                            {--static : Install static site.}
                            {--force : Force publishing.}';

    protected $description = 'Install Atom and it\'s modules.';

    protected $baseMigrationName = '0000_00_00_999999_install_atom_base';

    protected $node = [
        'devDependencies' => [
            '@tailwindcss/typography' => '^0.5',
            'alpinejs' => '^3',
            'autoprefixer' => '^10',
            'postcss' => '^8',
            'postcss-import' => '^14',
            'tailwindcss' => '^3',
        ],
        'dependencies' => [
            'flatpickr' => '^4',
        ],
    ];

    protected $modules = [
        'base',
        'roles',
        'permissions',
        'taxes',
        'pages',
        'teams',
        'blogs',
        'enquiries',
        'ticketing',
        'plans',
        'products', 
        'promotions',
        'shareables',
        'contacts',
        'documents',
        'tenants',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('static')) {
            $this->installStatic();
        }
        else {
            if (!$this->hasRunMigrationBefore()) {
                $this->newLine();
                $this->error('You have not run any migration yet. Please run the migration for the first time before installing Atom.');
                $this->newLine();
                return;
            }
            else if (!$this->isBaseInstalled() && (
                !$this->argument('modules') ||
                !in_array('base', explode(',', $this->argument('modules')))
            )) {
                $this->newLine();
    
                if ($this->confirm('You must install the base first before other modules can be installed. Proceed?', true)) {
                    $this->installBase();
    
                    $this->newLine();
                    $this->info('Base installation done!');
                    $this->comment('Please run atom:install again to install modules.');
                    $this->newLine();
                }
                else return;
            }
            else {
                $selected = $this->argument('modules')
                    ? explode(',', $this->argument('modules'))
                    : $this->choice('Please select modules to install', array_merge(['all'], $this->modules), null, null, true);
    
                foreach ($this->modules as $module) {
                    if (in_array('all', $selected) || in_array($module, $selected)) {
                        call_user_func([$this, str()->camel('install-'.$module)]);
                        if ($module !== 'base') $this->markModuleEnabled($module);
                    }
                }
    
                $this->newLine();
                $this->info('All done!');
                $this->comment('Please execute "npm install && npm run dev" to build your assets.');
                $this->newLine();
            }
        }
    }

    /**
     * Mark module enabled
     */
    private function markModuleEnabled($module)
    {
        $query = DB::table('site_settings')->where('name', 'modules');

        $enabled = collect(json_decode($query->first()->value));
        $enabled->push($module);

        $value = $enabled->unique()->values()->all();

        $query->update(['value' => json_encode($value)]);
    }

    /**
     * Install tenants
     */
    private function installTenants()
    {
        $this->newLine();
        $this->info('Installing tenants table...');

        if (Schema::hasTable('tenants')) $this->warn('tenants table exists, skipped.');
        else {
            Schema::create('tenants', function(Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('website')->nullable();
                $table->string('brn')->nullable();
                $table->text('address_1')->nullable();
                $table->text('address_2')->nullable();
                $table->string('city')->nullable();
                $table->string('zip')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->foreignId('avatar_id')->nullable()->constrained('files')->onDelete('set null');
                $table->timestamps();
            });

            Schema::create('tenant_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->indexed();
                $table->json('value')->nullable();
                $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            });

            Schema::create('tenant_users', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_owner')->nullable();
                $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamp('invited_at')->nullable();
                $table->timestamp('accepted_at')->nullable();
                $table->timestamps();
                $table->timestamp('blocked_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->foreignId('blocked_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            });    
        }
    }

    /**
     * Install documents
     */
    private function installDocuments()
    {
        $this->newLine();
        $this->info('Installing documents table...');

        $this->installContacts();
        $this->installTaxes();

        if (Schema::hasTable('documents')) $this->warn('documents table exists, skipped.');
        else {
            Schema::create('documents', function($table) {
                $table->id();
                $table->string('type')->nullable();
                $table->string('prefix')->nullable();
                $table->string('postfix')->nullable();
                $table->string('rev')->nullable();
                $table->string('number')->nullable()->indexed();
                $table->string('name')->nullable();
                $table->string('address')->nullable();
                $table->string('person')->nullable();
                $table->string('reference')->nullable();
                $table->string('payterm')->nullable();
                $table->text('description')->nullable();
                $table->text('summary')->nullable();
                $table->string('currency')->nullable();
                $table->decimal('currency_rate', 20, 2)->nullable();
                $table->decimal('subtotal', 20, 2)->nullable();
                $table->decimal('discount_total', 20, 2)->nullable();
                $table->decimal('tax_total', 20, 2)->nullable();
                $table->decimal('paid_total', 20, 2)->nullable();
                $table->decimal('grand_total', 20, 2)->nullable();
                $table->decimal('splitted_total', 20, 2)->nullable();
                $table->text('footer')->nullable();
                $table->text('note')->nullable();
                $table->json('data')->nullable();
                $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
                $table->foreignId('shareable_id')->nullable()->constrained('shareables')->onDelete('set null');
                $table->foreignId('revision_for_id')->nullable()->constrained('documents')->onDelete('cascade');
                $table->foreignId('converted_from_id')->nullable()->constrained('documents')->onDelete('set null');
                $table->foreignId('splitted_from_id')->nullable()->constrained('documents')->onDelete('cascade');
                $table->date('issued_at')->nullable();
                $table->date('due_at')->nullable();
                $table->timestamp('last_sent_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('owned_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            });
        }

        if (Schema::hasTable('document_items')) $this->warn('document_items table exists, skipped.');
        else {
            Schema::create('document_items', function($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->longText('description')->nullable();
                $table->decimal('qty', 20, 2)->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->decimal('subtotal', 20, 2)->nullable();
                $table->integer('seq')->nullable();

                if (Schema::hasTable('products')) {
                    $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                    $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->onDelete('set null');                    
                }
                
                $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('document_item_taxes')) $this->warn('document_item_taxes table exists, skipped.');
        else {
            Schema::create('document_item_taxes', function($table) {
                $table->id();
                $table->decimal('amount', 20, 2)->nullable();
                $table->foreignId('tax_id')->nullable()->constrained('taxes')->onDelete('set null');
                $table->foreignId('document_item_id')->constrained('document_items')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('document_files')) $this->warn('document_files table exists, skipped.');
        else {
            Schema::create('document_files', function($table) {
                $table->id();
                $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
                $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('document_emails')) $this->warn('document_emails table exists, skipped.');
        else {
            Schema::create('document_emails', function($table) {
                $table->id();
                $table->json('from')->nullable();
                $table->json('to')->nullable();
                $table->json('cc')->nullable();
                $table->json('bcc')->nullable();
                $table->string('subject')->nullable();
                $table->longText('body')->nullable();
                $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });
        }

        if (Schema::hasTable('document_payments')) $this->warn('document_payments table exists, skipped.');
        else {
            Schema::create('document_payments', function($table) {
                $table->id();
                $table->string('number')->indexed();
                $table->string('paymode')->nullable();
                $table->string('currency')->nullable();
                $table->decimal('currency_rate', 20, 2)->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
                $table->date('paid_at')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });
        }

        if (Schema::hasTable('document_labels')) $this->warn('document_labels table exists, skipped.');
        else {
            Schema::create('document_labels', function ($table) {
                $table->id();
                $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
                $table->foreignId('label_id')->constrained('labels')->onDelete('cascade');
            });

            $this->line('document_labels table created successfully.');
        }
    }

    /**
     * Install contacts
     */
    private function installContacts()
    {
        $this->newLine();
        $this->info('Installing contacts table...');

        if (Schema::hasTable('contacts')) $this->warn('contacts table exists, skipped.');
        else {
            Schema::create('contacts', function($table) {
                $table->id();
                $table->string('category')->nullable();
                $table->string('type')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('brn')->nullable();
                $table->string('tax_number')->nullable();
                $table->string('website')->nullable();
                $table->string('address_1')->nullable();
                $table->string('address_2')->nullable();
                $table->string('zip')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->json('data')->nullable();
                $table->foreignId('avatar_id')->nullable()->constrained('files')->onDelete('set null');
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('owned_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('contact_persons')) $this->warn('contact_persons table exists, skipped.');
        else {
            Schema::create('contact_persons', function($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('salutation')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('designation')->nullable();
                $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Install shareables
     */
    private function installShareables()
    {
        $this->newLine();
        $this->info('Installing shareables table...');

        if (Schema::hasTable('shareables')) $this->warn('shareables table exists, skipped.');
        else {
            Schema::create('shareables', function($table) {
                $table->id();
                $table->uuid();
                $table->integer('valid_for')->nullable();
                $table->json('data')->nullable();
                $table->timestamp('expired_at')->nullable();
                $table->timestamps();
            });

            $this->line('shareables table created successfully.');
        }
    }

    /**
     * Install promotions
     */
    private function installPromotions()
    {
        $this->newLine();
        $this->info('Installing promotions table...');

        if (Schema::hasTable('promotions')) $this->warn('promotions table exists, skipped.');
        else {
            Schema::create('promotions', function ($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('code')->indexed()->nullable();
                $table->string('type')->nullable();
                $table->decimal('rate', 20, 2)->nullable();
                $table->integer('usable_limit')->nullable();
                $table->text('description')->nullable();
                $table->json('data')->nullable();
                $table->datetime('end_at')->nullable();
                $table->boolean('is_active')->nullable();

                if (Schema::hasTable('products')) {
                    $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
                }

                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('promotions table created successfully.');
        }
    }

    /**
     * Install products
     */
    private function installProducts()
    {
        $this->newLine();
        $this->info('Installing products module...');

        $this->installTaxes();

        if (Schema::hasTable('products')) $this->warn('products table exists, skipped.');
        else {
            Schema::create('products', function($table) {
                $table->id();
                $table->string('name');
                $table->string('code')->nullable()->index();
                $table->string('type')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 20, 2)->nullable();
                $table->decimal('stock', 20, 2)->nullable();
                $table->boolean('is_active')->nullable();
                $table->timestamps();
            });

            $this->line('products table created successfully.');
        }

        if (Schema::hasTable('product_images')) $this->warn('product_images table exists, skipped.');
        else {
            Schema::create('product_images', function($table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('file_id')->constrained()->onDelete('cascade');
                $table->integer('seq')->nullable();
            });

            $this->line('product_images table created successfully.');
        }

        if (Schema::hasTable('product_categories')) $this->warn('product_categories table exists, skipped.');
        else {
            Schema::create('product_categories', function($table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('label_id')->constrained()->onDelete('cascade');
            });

            $this->line('product_categories table created successfully.');
        }

        if (Schema::hasTable('product_variants')) $this->warn('product_variants table exists, skipped.');
        else {
            Schema::create('product_variants', function($table) {
                $table->id();
                $table->string('name');
                $table->string('code')->nullable()->index();
                $table->decimal('price', 20, 2)->nullable();
                $table->decimal('stock', 20, 2)->nullable();
                $table->integer('seq')->nullable();
                $table->boolean('is_default')->nullable();
                $table->boolean('is_active')->nullable();
                $table->foreignId('image_id')->nullable()->constrained('files')->onDelete('set null');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });

            $this->line('product_variants table created successfully.');
        }

        if (Schema::hasTable('product_taxes')) $this->warn('product_taxes table exists, skipped.');
        else {
            Schema::create('product_taxes', function($table) {
                $table->id();
                $table->foreignId('tax_id')->constrained('taxes')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            });

            $this->line('product_taxes table created successfully.');
        }
    }

    /**
     * Install plans
     */
    private function installPlans()
    {
        $this->newLine();
        $this->info('Installing plans module...');

        $this->installTaxes();

        if (Schema::hasTable('plans')) $this->warn('plans table exists, skipped.');
        else {
            Schema::create('plans', function($table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->unsignedInteger('trial')->nullable();
                $table->string('payment_description')->nullable();
                $table->text('excerpt')->nullable();
                $table->json('features')->nullable();
                $table->string('cta')->nullable();
                $table->boolean('is_active')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('plans table created successfully.');
        }
    
        if (Schema::hasTable('plan_prices')) $this->warn('plan_prices table exists, skipped.');
        else {
            Schema::create('plan_prices', function ($table) {
                $table->id();
                $table->string('currency')->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->decimal('discount', 20, 2)->nullable();
                $table->string('country')->nullable();
                $table->string('shoutout')->nullable();
                $table->integer('expired_after')->nullable();
                $table->boolean('is_recurring')->nullable();
                $table->boolean('is_default')->nullable();
                $table->foreignId('tax_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('plan_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('plan_prices table created successfully.');
        }
    
        if (Schema::hasTable('plan_upgradables')) $this->warn('plan_upgradables table exists, skipped');
        else {
            Schema::create('plan_upgradables', function($table) {
                $table->id();
                $table->foreignId('plan_id')->constrained()->onDelete('cascade');
                $table->foreignId('upgradable_id')->constrained('plans')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('plan_downgradables')) $this->warn('plan_downgradables table exists, skipped');
        else {
            Schema::create('plan_downgradables', function($table) {
                $table->id();
                $table->foreignId('plan_id')->constrained()->onDelete('cascade');
                $table->foreignId('downgradable_id')->constrained('plans')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('plan_orders')) $this->warn('plan_orders table exists, skipped.');
        else {
            Schema::create('plan_orders', function($table) {
                $table->id();
                $table->string('number')->nullable()->unique();
                $table->string('currency')->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->json('data')->nullable();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->timestamps();
            });

            $this->line('plan_orders table created successfully.');
        }

        if (Schema::hasTable('plan_order_items')) $this->warn('plan_order_items table exists, skipped.');
        else {
            Schema::create('plan_order_items', function($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('currency')->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->decimal('discounted_amount', 20, 2)->nullable();
                $table->decimal('grand_total', 20, 2)->nullable();
                $table->json('data')->nullable();
                $table->foreignId('plan_order_id')->constrained()->onDelete('cascade');
                $table->foreignId('plan_price_id')->nullable()->constrained()->onDelete('set null');
                $table->timestamps();
            });

            $this->line('plan_order_items table created successfully.');
        }

        if (Schema::hasTable('plan_payments')) $this->warn('plan_payments table exists, skipped.');
        else {
            Schema::create('plan_payments', function($table) {
                $table->id();
                $table->string('number')->nullable()->unique();
                $table->string('currency')->nullable();
                $table->decimal('amount', 20, 2)->nullable();
                $table->string('status')->nullable();
                $table->string('provider')->nullable();
                $table->json('data')->nullable();
                $table->foreignId('plan_order_id')->nullable()->constrained()->onDelete('set null');
                $table->timestamp('provisioned_at')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('plan_payments table created successfully.');
        }

        if (Schema::hasTable('plan_subscriptions')) $this->warn('plan_subscriptions table exists, skipped.');
        else {
            Schema::create('plan_subscriptions', function($table) {
                $table->id();
                $table->boolean('is_trial')->nullable();
                $table->timestamp('start_at')->nullable();
                $table->timestamp('expired_at')->nullable();
                $table->json('data')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('plan_order_item_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('plan_price_id')->nullable()->constrained()->onDelete('set null');
                $table->timestamps();
            });

            $this->line('plan_subscriptions table created successfully.');
        }

        if (DB::table('plans')->count()) $this->warn('There are data in plans table, skipped populating dummy data.');
        else {
            DB::table('plans')->insert(collect([
                [
                    'name' => 'Starter',
                    'excerpt' => 'Get started with your first few projects.',
                    'payment_description' => 'Atom Starter Plan',
                    'cta' => 'Get Started',
                ],
                [
                    'name' => 'Pro',
                    'excerpt' => 'For professionals who need extra support, controls and security.',
                    'payment_description' => 'Atom Pro Plan',
                    'cta' => 'Upgrade to Pro',
                ],
            ])->map(fn($val) => array_merge($val, [
                'slug' => str($val['name'])->slug(),
                'trial' => 14,
                'features' => json_encode([
                    'Lorem ipsum dolor sit amet 1',
                    'Lorem ipsum dolor sit amet 2',
                    'Lorem ipsum dolor sit amet 3',
                    'Lorem ipsum dolor sit amet 4',
                    'Lorem ipsum dolor sit amet 5',
                    'Lorem ipsum dolor sit amet 6',
                    'Lorem ipsum dolor sit amet 7',
                    'Lorem ipsum dolor sit amet 8',
                    'Lorem ipsum dolor sit amet 9',
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]))->values()->all());

            DB::table('plan_prices')->insert(collect([
                [
                    'amount' => 50,
                    'expired_after' => 1,
                    'is_default' => true,
                    'plan_id' => 1,
                ],
                [
                    'amount' => 550,
                    'expired_after' => 12,
                    'shoutout' => 'Save 10%!',
                    'plan_id' => 1,
                ],
                [
                    'amount' => 99,
                    'expired_after' => 1,
                    'is_default' => true,
                    'plan_id' => 2,
                ],
                [
                    'amount' => 1100,
                    'expired_after' => 12,
                    'shoutout' => 'Save 20%!',
                    'plan_id' => 2,
                ],
            ])->map(fn($val) => array_merge($val, [
                'currency' => 'MYR',
                'country' => 'MY',
                'shoutout' => $val['shoutout'] ?? null,
                'is_default' => $val['is_default'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]))->values()->all());

            $this->line('Added dummy plans.');
        }
    }

    /**
     * Install ticketing
     */
    private function installTicketing()
    {
        $this->newLine();
        $this->info('Installing ticketing module...');

        if (Schema::hasTable('tickets')) $this->warn('tickets table exists, skipped.');
        else {
            Schema::create('tickets', function ($table) {
                $table->id();
                $table->string('number')->unique();
                $table->string('subject')->nullable();
                $table->longText('description')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            });

            $this->line('tickets table created successfully.');
        }

        if (Schema::hasTable('ticket_comments')) $this->warn('ticket_comments table exists, skipped.');
        else {
            Schema::create('ticket_comments', function($table) {
                $table->id();
                $table->text('body')->nullable();
                $table->boolean('is_read')->nullable();
                $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('cascade');
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            });

            $this->line('ticket_comments table created successfully.');
        }
    }

    /**
     * Install enquiries
     */
    private function installEnquiries()
    {
        $this->newLine();
        $this->info('Installing enquiries...');

        if (Schema::hasTable('enquiries')) $this->warn('enquiries table exists, skipped.');
        else {
            Schema::create('enquiries', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->longText('message')->nullable();
                $table->longText('remark')->nullable();
                $table->json('data')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
            });

            $this->line('enquiries table created successfully.');
        }
    }

    /**
     * Install blogs
     */
    private function installBlogs()
    {
        $this->newLine();
        $this->info('Installing blogs...');

        if (Schema::hasTable('blogs')) $this->warn('blogs table exists, skipped.');
        else {
            Schema::create('blogs', function ($table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->nullable();
                $table->string('redirect_slug')->nullable();
                $table->text('excerpt')->nullable();
                $table->longText('content')->nullable();
                $table->json('seo')->nullable();
                $table->foreignId('cover_id')->nullable()->constrained('files')->onDelete('set null');
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('blogs table created successfully.');
        }

        if (Schema::hasTable('blog_labels')) $this->warn('blog_labels table exists, skipped.');
        else {
            Schema::create('blog_labels', function ($table) {
                $table->id();
                $table->foreignId('blog_id')->constrained('blogs')->onDelete('cascade');
                $table->foreignId('label_id')->constrained('labels')->onDelete('cascade');
            });

            $this->line('blog_labels table created successfully.');
        }
    }

    /**
     * Install teams
     */
    private function installTeams()
    {
        $this->newLine();
        $this->info('Installing teams...');

        if (Schema::hasTable('teams')) $this->warn('teams table exists, skipped.');
        else {
            Schema::create('teams', function ($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });
            $this->line('teams table created successfully.');
        }

        if (Schema::hasTable('team_users')) $this->warn('team_users table exists, skipped.');
        else {
            Schema::create('team_users', function ($table) {
                $table->id();
                $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            });
            $this->line('team_users table created successfully.');
        }
    }

    /**
     * Install pages
     */
    private function installPages()
    {
        $this->newLine();
        $this->info('Installing pages...');

        if (Schema::hasTable('pages')) $this->warn('pages table exists, skipped.');
        else {
            Schema::create('pages', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('locale')->nullable();
                $table->longText('content')->nullable();
                $table->json('seo')->nullable();
                $table->json('data')->nullable();
                $table->timestamps();
            });
            $this->line('pages table created successfully.');
        }

        foreach ([
            ['name' => 'Privacy', 'title' => 'Privacy Policy', 'slug' => 'privacy'],
            ['name' => 'Terms', 'title' => 'Terms and Conditions', 'slug' => 'terms'],
        ] as $page) {
            if (DB::table('pages')->where('slug', $page['slug'])->count()) continue;

            DB::table('pages')->insert(array_merge($page, [
                'locale' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        $this->line('Added default pages.');

        foreach ([
            ['name' => 'company', 'value' => null],
            ['name' => 'phone', 'value' => null],
            ['name' => 'email', 'value' => null],
            ['name' => 'address', 'value' => null],
            ['name' => 'gmap_url', 'value' => null],
            ['name' => 'briefs', 'value' => null],
            ['name' => 'facebook', 'value' => null],
            ['name' => 'instagram', 'value' => null],
            ['name' => 'twitter', 'value' => null],
            ['name' => 'linkedin', 'value' => null],
            ['name' => 'youtube', 'value' => null],
            ['name' => 'spotify', 'value' => null],
            ['name' => 'tiktok', 'value' => null],
            ['name' => 'seo_title', 'value' => null],
            ['name' => 'seo_description', 'value' => null],
            ['name' => 'seo_image', 'value' => null],
            ['name' => 'ga_id', 'value' => null],
            ['name' => 'gtm_id', 'value' => null],
            ['name' => 'fbpixel_id', 'value' => null],
            ['name' => 'whatsapp', 'value' => null],
            ['name' => 'whatsapp_bubble', 'value' => false],
            ['name' => 'whatsapp_text', 'value' => null],
            ['name' => 'announcements', 'value' => json_encode([])],
        ] as $setting) {
            if (DB::table('site_settings')->where('name', $setting['name'])->count()) continue;
            DB::table('site_settings')->insert($setting);
        }
        $this->line('Added additional site settings.');
    }

    /**
     * Install taxes
     */
    private function installTaxes()
    {
        $this->newLine();
        $this->info('Installing taxes module...');

        if (Schema::hasTable('taxes')) $this->warn('taxes table exists, skipped.');
        else {
            Schema::create('taxes', function($table) {
                $table->id();
                $table->string('name');
                $table->decimal('rate', 20, 2)->nullable();
                $table->string('country')->nullable();
                $table->string('region')->nullable();
                $table->boolean('is_active')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            });

            $this->line('taxes table created successfully.');
        }
    }

    /**
     * Install permissions
     */
    private function installPermissions()
    {
        $this->newLine();
        $this->info('Installing permissions...');

        if (Schema::hasTable('user_permissions')) $this->warn('user_permissions table exists, skipped.');
        else {
            Schema::create('user_permissions', function($table) {
                $table->id();
                $table->string('permission');
                $table->boolean('is_granted')->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            });

            $this->line('user_permissions table created successfully.');
        }

        if (Schema::hasTable('roles')) {
            if (Schema::hasTable('role_permissions')) $this->warn('role_permissions table exists, skipped.');
            else {
                Schema::create('role_permissions', function ($table) {
                    $table->id();
                    $table->string('permission');
                    $table->boolean('is_granted')->nullable();
                    $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('cascade');
                });
    
                $this->line('role_permissions table created successfully.');
            }
        }
    }

    /**
     * Install roles
     */
    private function installRoles()
    {
        $this->newLine();
        $this->info('Installing roles...');

        if (Schema::hasTable('roles')) $this->warn('roles table exists, skipped.');
        else {
            Schema::create('roles', function ($table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });
            
            $this->line('roles table created successfully.');
        }

        if (Schema::hasColumn('users', 'role_id')) $this->warn('users table already has role_id column, skipped.');
        else {
            Schema::table('users', function ($table) {
                $table->foreignId('role_id')->nullable()->after('visibility')->constrained('roles')->onDelete('set null');
            });
            $this->line('Added role_id column to users table.');
        }
    }

    /**
     * Install site settings
     */
    private function installSiteSettings()
    {
        $this->newLine();
        $this->info('Installing site settings module...');

        if (Schema::hasTable('site_settings')) $this->warn('site_settings table exists, skipped.');
        else {
            Schema::create('site_settings', function ($table) {
                $table->id();
                $table->string('name')->unique();
                $table->longText('value')->nullable();
            });

            $this->line('site_settings table installed successfully.');
        }

        foreach ([
            ['name' => 'modules', 'value' => null],
            ['name' => 'mailer', 'value' => 'smtp'],
            ['name' => 'smtp_host', 'value' => 'smtp.mailtrap.io'],
            ['name' => 'smtp_port', 'value' => '2525'],
            ['name' => 'smtp_username', 'value' => '1f6300b6d6e996'],
            ['name' => 'smtp_password', 'value' => '33647bb47622ee'],
            ['name' => 'smtp_encryption', 'value' => 'tls'],
            ['name' => 'mailgun_domain', 'value' => null],
            ['name' => 'mailgun_secret', 'value' => null],
            ['name' => 'notify_from', 'value' => 'no-reply@atom.test'],
            ['name' => 'notify_to', 'value' => 'admin@atom.test'],
            ['name' => 'filesystem', 'value' => 'local'],
            ['name' => 'do_spaces_key', 'value' => null],
            ['name' => 'do_spaces_secret', 'value' => null],
            ['name' => 'do_spaces_region', 'value' => 'sgp1'],
            ['name' => 'do_spaces_bucket', 'value' => null],
            ['name' => 'do_spaces_endpoint', 'value' => 'https://sgp1.digitaloceanspaces.com'],
            ['name' => 'do_spaces_folder', 'value' => null],
            ['name' => 'google_client_id', 'value' => null],
            ['name' => 'google_client_secret', 'value' => null],
            ['name' => 'facebook_client_id', 'value' => null],
            ['name' => 'facebook_client_secret', 'value' => null],
            ['name' => 'linkedin_client_id', 'value' => null],
            ['name' => 'linkedin_client_secret', 'value' => null],
            ['name' => 'github_client_id', 'value' => null],
            ['name' => 'github_client_secret', 'value' => null],
            ['name' => 'twitter_client_id', 'value' => null],
            ['name' => 'twitter_client_secret', 'value' => null],
            ['name' => 'stripe_public_key', 'value' => null],
            ['name' => 'stripe_secret_key', 'value' => null],
            ['name' => 'stripe_webhook_signing_secret', 'value' => null],
            ['name' => 'gkash_mid', 'value' => null],
            ['name' => 'gkash_signature_key', 'value' => null],
            ['name' => 'gkash_api_version', 'value' => '1.5.5'],
            ['name' => 'gkash_sandbox_url', 'value' => 'https://api-staging.pay.asia/api/PaymentForm.aspx'],
            ['name' => 'gkash_url', 'value' => 'https://api.gkash.my/api/PaymentForm.aspx'],
            ['name' => 'ozopay_tid', 'value' => null],
            ['name' => 'ozopay_secret', 'value' => null],
            ['name' => 'ozopay_sandbox_url', 'value' => 'https://uatpayment.ozopay.com/PaymentEntry/PaymentOption'],
            ['name' => 'ozopay_url', 'value' => 'https://checkout.ozopay.com/Paymententry/PaymentOption'],
            ['name' => 'ipay_merchant_code', 'value' => null],
            ['name' => 'ipay_merchant_key', 'value' => null],
            ['name' => 'ipay_url', 'value' => 'https://payment.ipay88.com.my/epayment/entry.asp'],
            ['name' => 'ipay_query_url', 'value' => 'https://payment.ipay88.com.my/epayment/enquiry.asp'],
        ] as $setting) {
            if (DB::table('site_settings')->where('name', $setting['name'])->count()) continue;
            DB::table('site_settings')->insert($setting);
        }

        $this->line('Added default site settings.');
    }

    /**
     * Install files
     */
    private function installFiles()
    {
        $this->newLine();
        $this->info('Installing files module...');

        if (Schema::hasTable('files')) $this->warn('files table exists, skipped.');
        else {
            Schema::create('files', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('mime')->nullable();
                $table->decimal('size', 20, 2)->nullable();
                $table->text('url')->nullable();
                $table->json('data')->nullable();
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            });
    
            $this->line('files table created successfully.');
        }
    }

    /**
     * Install labels
     */
    private function installLabels()
    {
        $this->newLine();
        $this->info('Installing labels module...');

        if (Schema::hasTable('labels')) $this->warn('labels table exists, skipped.');
        else {
            Schema::create('labels', function ($table) {
                $table->id();
                $table->json('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('type')->nullable();
                $table->integer('seq')->nullable();
                $table->json('data')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('labels')->onDelete('cascade');
                $table->timestamps();
            });
    
            $this->line('labels table installed successfully.');
        }
    }

    /**
     * Install users
     */
    private function installUsers()
    {
        $this->newLine();
        $this->info('Installing users module...');

        Schema::table('users', function ($table) {
            $table->string('password')->nullable()->change();
            $table->timestamp('last_active_at')->nullable()->after('remember_token');
            $table->timestamp('login_at')->nullable()->after('remember_token');
            $table->timestamp('activated_at')->nullable()->after('remember_token');
            $table->timestamp('onboarded_at')->nullable()->after('remember_token');
            $table->timestamp('signup_at')->nullable()->after('remember_token');
            $table->boolean('is_root')->nullable()->after('remember_token');
            $table->string('status')->nullable()->after('remember_token');
            $table->string('visibility')->nullable()->after('remember_token');
            $table->json('data')->nullable()->after('remember_token');
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('blocked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
        });

        $this->line('users table installed successfully.');

        // create root user
        $rootEmail = 'root@jiannius.com';
        if (DB::table('users')->where('email', $rootEmail)->count()) $this->warn('Root user exists, skipped.');
        else {
            DB::table('users')->insert([
                'name' => 'Root',
                'email' => $rootEmail,
                'password' => bcrypt('password'),
                'visibility' => 'global',
                'status' => 'active',
                'is_root' => true,
                'email_verified_at' => now(),
                'activated_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->line('Added Root user.');
        }
    }

    /**
     * Install base
     */
    private function installBase()
    {
        DB::table('migrations')->where('migration', $this->baseMigrationName)->delete();

        $this->newLine();
        $this->info('Base installation...');

        $this->call('atom:publish', [
            'modules' => 'base',
            '--force' => $this->option('force'),
        ]);

        $this->removeLaravelInstalltionFiles();
        $this->installUsers();
        $this->installLabels();
        $this->installFiles();
        $this->installSiteSettings();
        $this->updateNodePackages();
        $this->updateHomeRoute();
        $this->linkStorage();

        DB::table('migrations')->insert([
            'migration' => $this->baseMigrationName,
            'batch' => (DB::table('migrations')->max('batch') ?? 1) + 1,
        ]);
    }

    /**
     * Install static site
     */
    private function installStatic()
    {
        $this->call('atom:publish', [
            '--static' => true,
            '--force' => $this->option('force'),
        ]);

        $this->updateNodePackages();
        $this->updateHomeRoute();
        $this->linkStorage();
    }

    /**
     * Check migration has run before
     */
    private function hasRunMigrationBefore()
    {
        return Schema::hasTable('migrations') && DB::table('migrations')->count();
    }

    /**
     * Check base is installed
     */
    private function isBaseInstalled()
    {
        return DB::table('migrations')->where('migration', $this->baseMigrationName)->count() > 0;
    }

    /**
     * Update node packages
     * 
     * @return void
     */
    public function updateNodePackages()
    {
        // dev dependencies
        $this->writePackageJsonFile(function ($packages) {
            return $this->node['devDependencies'] + $packages;
        });
        $this->line('Updated dev dependencies in package.json');

        // dependencies
        $this->writePackageJsonFile(function ($packages) {
            return $this->node['dependencies'] + $packages;
        }, false);
        $this->line('Updated dependencies in package.json');
    }

    /**
     * Update home route
     */
    private function updateHomeRoute()
    {
        replace_in_file(
            'public const HOME = \'/home\';',
            'public const HOME = \'/\';',
            app_path('Providers/RouteServiceProvider.php')
        );

        $this->line('Updated HOME constant in RouteServiceProvider.php');
    }

    /**
     * Link storage folder
     */
    private function linkStorage()
    {
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }
    }

    /**
     * Remove laravel installation files
     */
    private function removeLaravelInstalltionFiles()
    {
        if (!$this->option('force')) return;
        
        collect([
            base_path('resources/views/welcome.blade.php'),
            base_path('resources/js/bootstrap.js'),
        ])->each(function($file) {
            if (file_exists($file)) unlink($file);
        });

        $routes = base_path('routes/web.php');
        file_put_contents($routes, '');
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function writePackageJsonFile(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}