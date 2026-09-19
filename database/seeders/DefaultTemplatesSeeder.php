<?php

namespace Database\Seeders;

use App\Models\ResumeTemplate;
use Illuminate\Database\Seeder;

class DefaultTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        ResumeTemplate::updateOrCreate(
            ['name' => 'Classic'],
            [
                'is_default' => true,
                'html' => <<<'HTML'
                <div style="font-family: Georgia, serif; padding: 40px; max-width: 700px; margin: 0 auto;">
                    <div style="text-align:center; margin-bottom:24px;">
                        <div style="font-size:26px; color:#152238;">{{name}}</div>
                        <div style="font-size:14px; color:#b8860b; margin-top:4px;">{{title}}</div>
                        <div style="font-size:12px; color:#6b6b6b; margin-top:8px; font-family:sans-serif;">{{email}} · {{phone}} · {{location}} · {{links}}</div>
                    </div>
                    <div style="margin-bottom:20px;">
                        <div style="font-size:12px; font-weight:600; border-bottom:1px solid #b8860b55; padding-bottom:3px; font-family:sans-serif;">SUMMARY</div>
                        <p style="font-size:14px; line-height:1.6;">{{summary}}</p>
                    </div>
                    <div style="margin-bottom:20px;">
                        <div style="font-size:12px; font-weight:600; border-bottom:1px solid #b8860b55; padding-bottom:3px; font-family:sans-serif;">EXPERIENCE</div>
                        {{#experience}}
                        <div style="margin-top:10px;">
                            <strong style="font-size:14px;">{{role}} · {{company}}</strong>
                            <span style="float:right; font-size:12px; color:#8a8a8a; font-family:sans-serif;">{{period}}</span>
                            {{bullets_html}}
                        </div>
                        {{/experience}}
                    </div>
                    <div style="margin-bottom:20px;">
                        <div style="font-size:12px; font-weight:600; border-bottom:1px solid #b8860b55; padding-bottom:3px; font-family:sans-serif;">EDUCATION</div>
                        {{#education}}
                        <div style="margin-top:8px; display:flex; justify-content:space-between;">
                            <span style="font-size:14px;">{{degree}}, {{school}}</span>
                            <span style="font-size:12px; color:#8a8a8a; font-family:sans-serif;">{{period}}</span>
                        </div>
                        {{/education}}
                    </div>
                    <div>
                        <div style="font-size:12px; font-weight:600; border-bottom:1px solid #b8860b55; padding-bottom:3px; font-family:sans-serif;">SKILLS</div>
                        <p style="font-size:14px;">{{skills}}</p>
                    </div>
                </div>
                HTML,
            ]
        );

        ResumeTemplate::updateOrCreate(
            ['name' => 'Modern'],
            [
                'is_default' => true,
                'html' => <<<'HTML'
                <div style="font-family: Arial, sans-serif; padding: 0; max-width: 700px; margin: 0 auto;">
                    <div style="background:#152238; color:white; padding:30px 40px;">
                        <div style="font-size:26px;">{{name}}</div>
                        <div style="font-size:14px; color:#b8860b; margin-top:4px;">{{title}}</div>
                        <div style="font-size:12px; opacity:.8; margin-top:8px;">{{email}} · {{phone}} · {{location}} · {{links}}</div>
                    </div>
                    <div style="padding:30px 40px;">
                        <div style="margin-bottom:20px;">
                            <div style="font-size:12px; font-weight:700; color:#152238; text-transform:uppercase; letter-spacing:.06em;">Summary</div>
                            <p style="font-size:14px; line-height:1.6;">{{summary}}</p>
                        </div>
                        <div style="margin-bottom:20px;">
                            <div style="font-size:12px; font-weight:700; color:#152238; text-transform:uppercase; letter-spacing:.06em;">Experience</div>
                            {{#experience}}
                            <div style="margin-top:10px; border-left:3px solid #b8860b; padding-left:12px;">
                                <strong style="font-size:14px;">{{role}} · {{company}}</strong><br>
                                <span style="font-size:12px; color:#8a8a8a;">{{period}}</span>
                                {{bullets_html}}
                            </div>
                            {{/experience}}
                        </div>
                        <div style="margin-bottom:20px;">
                            <div style="font-size:12px; font-weight:700; color:#152238; text-transform:uppercase; letter-spacing:.06em;">Education</div>
                            {{#education}}
                            <div style="margin-top:8px;">
                                <span style="font-size:14px;">{{degree}}, {{school}}</span> —
                                <span style="font-size:12px; color:#8a8a8a;">{{period}}</span>
                            </div>
                            {{/education}}
                        </div>
                        <div>
                            <div style="font-size:12px; font-weight:700; color:#152238; text-transform:uppercase; letter-spacing:.06em;">Skills</div>
                            <p style="font-size:14px;">{{skills}}</p>
                        </div>
                    </div>
                </div>
                HTML,
            ]
        );
    }
}
