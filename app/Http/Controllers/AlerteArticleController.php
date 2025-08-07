<?php

namespace App\Http\Controllers;
use App\Models\AlerteArticle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class AlerteArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $user = auth()->user();


        if (!($user->hasRole('admin') || ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'))) {
        
        // if (!($user->hasRole(['magasinier_collation', 'admin']))) {

            return redirect()->back()->with('error', 'Vous n\'êtes pas   autorisé à voir les alertes des articles.');
        }

        $alerteArticles=AlerteArticle::with('article')
            ->orderByDesc('datedeclenchement')
            ->get();
        
        $nbAlertes=$alerteArticles->count();

        return view('alertes-articles.index',compact('alerteArticles','nbAlertes'));
    }

    

    

    /**
     * Display the specified resource.
     */
    public function show($alerteArt_id)
    {
        //

        $user = auth()->user();

        if (!($user->hasRole('admin') || ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'))) {
        // if (!($user->hasRole(['magasinier_collation', 'admin']))) {

            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir les alertes des articles.');
        } 

        $alerte=AlerteArticle::with('article')
            ->where('alerteArt_id',$alerteArt_id)
            ->firstOrFail();

        return view('alertes-articles.show',compact('alerte'));
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlerteArticle $alerte) : RedirectResponse
    {
        //

        $user = auth()->user();


        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimé les alertes des articles.');
        }

        $alerte->delete();

        return redirect()->route('alertes-articles.index')
        ->with('success', 'L’ alerte a bien été supprimée .');
    }
}
