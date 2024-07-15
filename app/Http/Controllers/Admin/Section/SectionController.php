<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\StoreRequest;
use App\Http\Requests\Section\UpdateRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index',[
            'sections' => Section::all()
        ]);
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->user()->id;
        Section::create($attributes);
        return redirect()->route('admin.sections.index')->with('success','تم إنشاء القسم بنجاح');
    }

    public function update(Section $section, UpdateRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->user()->id;
        $section->update($attributes);
        return redirect()->route('admin.sections.index')->with('success','تم تعديل القسم بنجاح');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success','تم حذف القسم بنجاح');
    }
}
