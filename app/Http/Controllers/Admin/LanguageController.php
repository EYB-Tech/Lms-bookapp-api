<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $total_available_languages = Language::where('status', 'Publish')->count();
        $total_not_available_languages = Language::where('status', 'Draft')->count();
        $status = $request->input('status', ''); // Default is 'all'
        $search = $request->input('search', '');   // Default is empty string
        $languages = Language::query();
        // Apply filter based on status
        if ($status != '') {
            $languages->where('status', $status);
        }
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $languages->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            });
        }
        // Get the filtered languages with pagination
        $languages = $languages->latest()->paginate(12);
        // Return the view with the languages and filters
        return view('admin.pages.languages.index', compact(
            'languages',
            'total_available_languages',
            'total_not_available_languages',
        ));
    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required|string:max:191|unique:languages,name',
            'slug' => 'required|string:max:191|unique:languages,slug',
            'status' => 'required|in:Draft,Publish',
            'direction' => 'required|in:rtl,ltr',
        ]);

        $language = Language::create($request_data);
        //generate admin panel string
        $backend_default_lang_data = file_get_contents(base_path('lang/') . 'default.json');
        file_put_contents(base_path('lang/') . $language->slug . '.json', $backend_default_lang_data);
        Artisan::call('cache:clear');
        session()->flash('success', __('Added successfully'));
        return redirect()->route('admin.languages.index');
    }

    public function show(Language $language)
    {
        $backend_lang_file_path = base_path('lang/') . $language->slug . '.json';
        if (!file_exists($backend_lang_file_path) && !is_dir($backend_lang_file_path)) {
            file_put_contents(base_path('lang/') . $language->slug . '.json', file_get_contents(base_path('lang/') . 'default.json'));
        }

        $all_word = file_get_contents(base_path('lang/') . $language->slug . '.json');
        $all_word = json_decode($all_word);
        return view('admin.pages.languages.show', compact('language', 'all_word'));
    }

    public function searchWords(Request $request, Language $language)
    {
        $search = trim($request->get('search'));

        // Validate search input
        if (empty($search) || strlen($search) < 2) {
            return response()->json(['error' => 'Search term must be at least 2 characters long.'], 400);
        }

        $langFilePath = base_path('lang/') . $language->slug . '.json';
        $defaultFilePath = base_path('lang/default.json');

        // Ensure language file exists by copying from default if necessary
        if (!is_file($langFilePath)) {
            if (is_file($defaultFilePath)) {
                file_put_contents($langFilePath, file_get_contents($defaultFilePath));
            } else {
                return response()->json(['error' => 'Default language file is missing.'], 500);
            }
        }

        // Load and decode JSON
        $allWordsJson = file_get_contents($langFilePath);
        $allWords = json_decode($allWordsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to parse language file.'], 500);
        }

        // Filter results
        $filteredWords = collect($allWords)->filter(function ($value, $key) use ($search) {
            $lowerSearch = strtolower($search);
            return stripos($key, $lowerSearch) !== false || stripos($value, $lowerSearch) !== false;
        });

        // Optionally sort the results
        $filteredWords = $filteredWords->sortKeys();

        return view('admin.pages.languages.words', [
            'all_word' => $filteredWords,
            'language' => $language,
        ])->render();
    }

    public function update(Request $request, Language $language)
    {
        $request_data = $request->validate([
            'name' => 'required|string:max:191|unique:languages,name,'.$language->id,
            'direction' => 'required|string:max:191',
            'status' => 'required|in:Draft,Publish',
            'slug' => 'required|string:max:191|unique:languages,slug,'.$language->id
        ]);
        $language->update($request_data);
        $backend_lang_file_path = base_path('lang/') . $request->slug . '.json';

        if (!file_exists($backend_lang_file_path) && !is_dir($backend_lang_file_path)) {
            file_put_contents(base_path('lang/') . $request->slug . '.json', file_get_contents(base_path('lang/') . 'default.json'));
        }
        Artisan::call('cache:clear');
        session()->flash('success', __('Updated successfully'));
        return redirect()->route('admin.languages.index');
    }

    public function updateWords(Request $request, Language $language)
    {
        $request_data = $request->validate([
            'string_key' => 'required',
            'translate_word' => 'required',
        ]);

        // get text json file
        // get current key index and replace it in the json file
        if (file_exists(base_path('lang/') . $language->slug . '.json')) {
            $default_lang_data = file_get_contents(base_path('lang') . '/' . $language->slug . '.json');
            $default_lang_data = (array)json_decode($default_lang_data);
            $default_lang_data[$request->string_key] = $request->translate_word;
            $default_lang_data = (object)$default_lang_data;
            $default_lang_data = json_encode($default_lang_data);
            file_put_contents(base_path('lang/') . $language->slug . '.json', $default_lang_data);
        }
        // session()->flash('success', __('Words Change Success'));
        // return redirect()->route('admin.languages.show', $language->id);
        Artisan::call('cache:clear');
        return response()->json(['message' => __('Words Change Success')], 201);
    }

    public function addNewWords(Request $request)
    {
        $request_data = $request->validate([
            'lang_slug' => 'required|string',
            'new_string' => 'required|string',
            'translate_string' => 'required|string',
        ]);
        if (file_exists(base_path('lang/') . $request->lang_slug . '.json')) {
            $default_lang_data = file_get_contents(base_path('lang') . '/' . $request->lang_slug . '.json');
            $default_lang_data = (array)json_decode($default_lang_data);
            $default_lang_data[$request->new_string] = $request->translate_string;
            $default_lang_data = (object)$default_lang_data;
            $default_lang_data = json_encode($default_lang_data);
            file_put_contents(base_path('lang/') . $request->lang_slug . '.json', $default_lang_data);
            session()->flash('success', __('New Word Successfully Added.'));
            return redirect()->back();
        }
        Artisan::call('cache:clear');
        session()->flash('warning', __('Not Found File Language'));
        return redirect()->back();
    }

    public function make_default(Language $language)
    {
        if ($language->default == 1) {
            session()->flash('warning', __('You do not have access'));
            return redirect()->back();
        }
        $name = $language->name;
        Language::where('default', 1)->update(['default' => 0]);
        $language->update(['default' => 1]);

        setEnvValue([
            'DEFAULT_LANGUAGE' => $language->slug
        ]);
        Artisan::call('cache:clear');
        session()->flash('success', __('Default language set to') . ' ' . $name);
        return redirect()->route('admin.languages.index');
    }

    public function destroy(Language $language)
    {
        if ($language->default == 1) {
            session()->flash('warning', __('You do not have access'));
            return redirect()->back();
        }

        $language->delete();
        Artisan::call('cache:clear');
        session()->flash('success', __('Deleted successfully'));
        return redirect()->route('admin.languages.index');
    }
}
